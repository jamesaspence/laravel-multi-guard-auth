<?php
/*
 * Handles redirect in exception handler
 * for unauthorized requests
 */

use App\Models\Role;

Route::redirect('login', '/guest/login')
    ->name('login');

Route::middleware('auth')->group(function () {
    Route::post('logout', 'LogoutController@logout')->name('logout');
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

    Route::middleware(['auth', 'hasRole:' . Role::GUEST_ROLE])->group(function () {
        Route::get('home', function () {
            return view('home');
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

    Route::middleware(['auth', 'hasRole:' . Role::HOST_ROLE])->group(function () {
        Route::get('home', function () {
            return view('home');
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

    Route::middleware(['auth', 'hasRole:' . Role::ADMIN_ROLE])->group(function () {
        Route::get('home', function () {
            return view('home');
        })->name('admin-home');
    });
});

