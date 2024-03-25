<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Starmoozie\Base Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Starmoozie\Base package.
|
*/

Route::group(
    [
        'namespace'  => 'Starmoozie\CRUD\app\Http\Controllers',
        'middleware' => config('starmoozie.base.web_middleware', 'web'),
        'prefix'     => config('starmoozie.base.route_prefix'),
    ],
    function () {
        // if not otherwise configured, setup the auth routes
        if (config('starmoozie.base.setup_auth_routes')) {
            // Authentication Routes...
            Route::get('login', 'Auth\LoginController@showLoginForm')->name('starmoozie.auth.login');
            Route::post('login', 'Auth\LoginController@login');
            Route::get('logout', 'Auth\LoginController@logout')->name('starmoozie.auth.logout');
            Route::post('logout', 'Auth\LoginController@logout');

            // Registration Routes...
            Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('starmoozie.auth.register');
            Route::post('register', 'Auth\RegisterController@register');

            // if not otherwise configured, setup the password recovery routes
            if (config('starmoozie.base.setup_password_recovery_routes', true)) {
                Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('starmoozie.auth.password.reset');
                Route::post('password/reset', 'Auth\ResetPasswordController@reset');
                Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('starmoozie.auth.password.reset.token');
                Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('starmoozie.auth.password.email')->middleware('starmoozie.throttle.password.recovery:' . config('starmoozie.base.password_recovery_throttle_access'));
            }

            if (config('starmoozie.base.setup_email_verification_routes', false)) {
                Route::get('email/verify', 'Auth\VerifyEmailController@emailVerificationRequired')->name('verification.notice');
                Route::get('email/verify/{id}/{hash}', 'Auth\VerifyEmailController@verifyEmail')->name('verification.verify');
                Route::post('email/verification-notification', 'Auth\VerifyEmailController@resendVerificationEmail')->name('verification.send');
            }
        }

        // if not otherwise configured, setup the dashboard routes
        if (config('starmoozie.base.setup_dashboard_routes')) {
            Route::get('dashboard', 'AdminController@dashboard')->name('starmoozie.dashboard');
            Route::get('/', 'AdminController@redirect')->name('starmoozie');
        }

        // if not otherwise configured, setup the "my account" routes
        if (config('starmoozie.base.setup_my_account_routes')) {
            Route::get('edit-account-info', 'MyAccountController@getAccountInfoForm')->name('starmoozie.account.info');
            Route::post('edit-account-info', 'MyAccountController@postAccountInfoForm')->name('starmoozie.account.info.store');
            Route::post('change-password', 'MyAccountController@postChangePasswordForm')->name('starmoozie.account.password');
        }
    }
);
