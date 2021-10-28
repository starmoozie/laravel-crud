<?php

namespace Starmoozie\CRUD;

use Starmoozie\CRUD\app\Http\Middleware\ThrottlePasswordRecovery;
use Starmoozie\CRUD\app\Library\CrudPanel\CrudPanel;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class StarmoozieServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Starmoozie\CRUD\app\Console\Commands\Install::class,
        \Starmoozie\CRUD\app\Console\Commands\AddSidebarContent::class,
        \Starmoozie\CRUD\app\Console\Commands\AddCustomRouteContent::class,
        \Starmoozie\CRUD\app\Console\Commands\Version::class,
        \Starmoozie\CRUD\app\Console\Commands\CreateUser::class,
        \Starmoozie\CRUD\app\Console\Commands\PublishStarmoozieMiddleware::class,
        \Starmoozie\CRUD\app\Console\Commands\PublishView::class,
    ];

    // Indicates if loading of the provider is deferred.
    protected $defer = false;
    // Where the route file lives, both inside the package and in the app (if overwritten).
    public $routeFilePath = '/routes/starmoozie/base.php';
    // Where custom routes can be written, and will be registered by Starmoozie.
    public $customRoutesFilePath = '/routes/starmoozie/custom.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->loadViewsWithFallbacks();
        $this->loadTranslationsFrom(realpath(__DIR__.'/resources/lang'), 'starmoozie');
        $this->loadConfigs();
        $this->registerMiddlewareGroup($this->app->router);
        $this->setupRoutes($this->app->router);
        $this->setupCustomRoutes($this->app->router);
        $this->publishFiles();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the CrudPanel object to Laravel's service container
        $this->app->singleton('crud', function ($app) {
            return new CrudPanel($app);
        });

        // Bind the widgets collection object to Laravel's service container
        $this->app->singleton('widgets', function ($app) {
            return new Collection();
        });

        // load a macro for Route,
        // helps developers load all routes for a CRUD resource in one line
        if (! Route::hasMacro('crud')) {
            $this->addRouteMacro();
        }

        // register the helper functions
        $this->loadHelpers();

        // register the artisan commands
        $this->commands($this->commands);
    }

    public function registerMiddlewareGroup(Router $router)
    {
        $middleware_key = config('starmoozie.base.middleware_key');
        $middleware_class = config('starmoozie.base.middleware_class');

        if (! is_array($middleware_class)) {
            $router->pushMiddlewareToGroup($middleware_key, $middleware_class);

            return;
        }

        foreach ($middleware_class as $middleware_class) {
            $router->pushMiddlewareToGroup($middleware_key, $middleware_class);
        }

        // register internal starmoozie middleware for throttling the password recovery functionality
        // but only if functionality is enabled by developer in config
        if (config('starmoozie.base.setup_password_recovery_routes')) {
            $router->aliasMiddleware('starmoozie.throttle.password.recovery', ThrottlePasswordRecovery::class);
        }
    }

    public function publishFiles()
    {
        $error_views = [__DIR__.'/resources/error_views' => resource_path('views/errors')];
        $starmoozie_views = [__DIR__.'/resources/views' => resource_path('views/vendor/starmoozie')];
        $starmoozie_public_assets = [__DIR__.'/public' => public_path()];
        $starmoozie_lang_files = [__DIR__.'/resources/lang' => resource_path('lang/vendor/starmoozie')];
        $starmoozie_config_files = [__DIR__.'/config' => config_path()];

        // sidebar content views, which are the only views most people need to overwrite
        $starmoozie_menu_contents_view = [
            __DIR__.'/resources/views/base/inc/sidebar_content.blade.php'      => resource_path('views/vendor/starmoozie/base/inc/sidebar_content.blade.php'),
            __DIR__.'/resources/views/base/inc/topbar_left_content.blade.php'  => resource_path('views/vendor/starmoozie/base/inc/topbar_left_content.blade.php'),
            __DIR__.'/resources/views/base/inc/topbar_right_content.blade.php' => resource_path('views/vendor/starmoozie/base/inc/topbar_right_content.blade.php'),
        ];
        $starmoozie_custom_routes_file = [__DIR__.$this->customRoutesFilePath => base_path($this->customRoutesFilePath)];

        // calculate the path from current directory to get the vendor path
        $vendorPath = dirname(__DIR__, 3);
        $gravatar_assets = [$vendorPath.'/creativeorange/gravatar/config' => config_path()];

        // establish the minimum amount of files that need to be published, for Starmoozie to work; there are the files that will be published by the install command
        $minimum = array_merge(
            // $starmoozie_views,
            // $starmoozie_lang_files,
            $error_views,
            $starmoozie_public_assets,
            $starmoozie_config_files,
            $starmoozie_menu_contents_view,
            $starmoozie_custom_routes_file,
            $gravatar_assets
        );

        // register all possible publish commands and assign tags to each
        $this->publishes($starmoozie_config_files, 'config');
        $this->publishes($starmoozie_lang_files, 'lang');
        $this->publishes($starmoozie_views, 'views');
        $this->publishes($starmoozie_menu_contents_view, 'menu_contents');
        $this->publishes($error_views, 'errors');
        $this->publishes($starmoozie_public_assets, 'public');
        $this->publishes($starmoozie_custom_routes_file, 'custom_routes');
        $this->publishes($gravatar_assets, 'gravatar');
        $this->publishes($minimum, 'minimum');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/starmoozie, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

    /**
     * Load custom routes file.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupCustomRoutes(Router $router)
    {
        // if the custom routes file is published, register its routes
        if (file_exists(base_path().$this->customRoutesFilePath)) {
            $this->loadRoutesFrom(base_path().$this->customRoutesFilePath);
        }
    }

    /**
     * The route macro allows developers to generate the routes for a CrudController,
     * for all operations, using a simple syntax: Route::crud().
     *
     * It will go to the given CrudController and get the setupRoutes() method on it.
     */
    private function addRouteMacro()
    {
        Route::macro('crud', function ($name, $controller) {
            // put together the route name prefix,
            // as passed to the Route::group() statements
            $routeName = '';
            if ($this->hasGroupStack()) {
                foreach ($this->getGroupStack() as $key => $groupStack) {
                    if (isset($groupStack['name'])) {
                        if (is_array($groupStack['name'])) {
                            $routeName = implode('', $groupStack['name']);
                        } else {
                            $routeName = $groupStack['name'];
                        }
                    }
                }
            }
            // add the name of the current entity to the route name prefix
            // the result will be the current route name (not ending in dot)
            $routeName .= $name;

            // get an instance of the controller
            if ($this->hasGroupStack()) {
                $groupStack = $this->getGroupStack();
                $groupNamespace = $groupStack && isset(end($groupStack)['namespace']) ? end($groupStack)['namespace'].'\\' : '';
            } else {
                $groupNamespace = '';
            }
            $namespacedController = $groupNamespace.$controller;
            $controllerInstance = App::make($namespacedController);

            return $controllerInstance->setupRoutes($name, $routeName, $controller);
        });
    }

    public function loadViewsWithFallbacks()
    {
        $customBaseFolder = resource_path('views/vendor/starmoozie/base');
        $customCrudFolder = resource_path('views/vendor/starmoozie/crud');

        // - first the published/overwritten views (in case they have any changes)
        if (file_exists($customBaseFolder)) {
            $this->loadViewsFrom($customBaseFolder, 'starmoozie');
        }
        if (file_exists($customCrudFolder)) {
            $this->loadViewsFrom($customCrudFolder, 'crud');
        }
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views/base'), 'starmoozie');
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views/crud'), 'crud');
    }

    public function loadConfigs()
    {
        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(__DIR__.'/config/starmoozie/crud.php', 'starmoozie.crud');
        $this->mergeConfigFrom(__DIR__.'/config/starmoozie/base.php', 'starmoozie.base');

        // add the root disk to filesystem configuration
        app()->config['filesystems.disks.'.config('starmoozie.base.root_disk_name')] = [
            'driver' => 'local',
            'root'   => base_path(),
        ];

        /*
         * Starmoozie login differs from the standard Laravel login.
         * As such, Starmoozie uses its own authentication provider, password broker and guard.
         *
         * THe process below adds those configuration values on top of whatever is in config/auth.php.
         * Developers can overwrite the starmoozie provider, password broker or guard by adding a
         * provider/broker/guard with the "starmoozie" name inside their config/auth.php file.
         * Or they can use another provider/broker/guard entirely, by changing the corresponding
         * value inside config/starmoozie/base.php
         */

        // add the starmoozie_users authentication provider to the configuration
        app()->config['auth.providers'] = app()->config['auth.providers'] +
        [
            'starmoozie' => [
                'driver'  => 'eloquent',
                'model'   => config('starmoozie.base.user_model_fqn'),
            ],
        ];

        // add the starmoozie_users password broker to the configuration
        app()->config['auth.passwords'] = app()->config['auth.passwords'] +
        [
            'starmoozie' => [
                'provider'  => 'starmoozie',
                'table'     => 'password_resets',
                'expire'   => 60,
                'throttle' => config('starmoozie.base.password_recovery_throttle_notifications'),
            ],
        ];

        // add the starmoozie_users guard to the configuration
        app()->config['auth.guards'] = app()->config['auth.guards'] +
        [
            'starmoozie' => [
                'driver'   => 'session',
                'provider' => 'starmoozie',
            ],
        ];
    }

    /**
     * Load the Starmoozie helper methods, for convenience.
     */
    public function loadHelpers()
    {
        require_once __DIR__.'/helpers.php';
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['crud', 'widgets'];
    }
}
