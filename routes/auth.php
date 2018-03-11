<?php
/*
 * Handles redirect in exception handler
 * for unauthorized requests
 */
Route::redirect('login', '/guest/login')
    ->name('login');

Route::middleware('auth')->group(function () {
    Route::post('logout', 'Auth\LogoutController@logout')->name('logout');
});

Route::prefix('guest')->group(function () {
    Route::namespace('Login')->group(function () {
        Route::get('login', 'GuestLoginController@showLoginForm')->name('guest-login');
        Route::post('login', 'GuestLoginController@login');
    });
    Route::namespace('Register')->group(function () {
        Route::get('register', 'GuestRegistrationController@showRegistrationForm')->name('guest-register');
        Route::post('register', 'GuestRegistrationController@register')->name('guest-register');
    });

    Route::middleware('auth')->group(function () {
        Route::get('home', function () {
            return 'Home!';
        })->name('guest-home');
    });
});

Route::prefix('host')->group(function () {
    Route::namespace('Login')->group(function () {
        Route::get('login', 'HostLoginController@showLoginForm')->name('host-login');
        Route::post('login', 'HostLoginController@login');
    });
    Route::namespace('Register')->group(function () {
        Route::get('register', 'HostRegistrationController@showRegistrationForm')->name('host-register');
        Route::post('register', 'HostRegistrationController@register')->name('host-register');
    });

    Route::middleware('auth')->group(function () {
        Route::get('home', function () {
            return 'Home!';
        })->name('host-home');
    });
});

Route::prefix('admin')->group(function () {
    Route::namespace('Login')->group(function () {
        Route::get('login', 'AdminLoginController@showLoginForm')->name('admin-login');
        Route::post('login', 'AdminLoginController@login');
    });
    Route::namespace('Register')->group(function () {
        Route::get('register', 'AdminRegistrationController@showRegistrationForm')->name('admin-register');
        Route::post('register', 'AdminRegistrationController@register')->name('admin-register');
    });

    Route::middleware('auth')->group(function () {
        Route::get('home', function () {
            return 'Home!';
        })->name('admin-home');
    });
});

