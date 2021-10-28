<?php

// --------------------------
// Custom Starmoozie Routes
// --------------------------
// This route file is loaded automatically by Starmoozie\Base.
// Routes you generate using Starmoozie\Generators will be placed here.

Route::group([
    'prefix'     => config('starmoozie.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('starmoozie.base.web_middleware', 'web'),
        (array) config('starmoozie.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
}); // this should be the absolute last line of this file
