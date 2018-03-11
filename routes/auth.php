<?php
/*
 * Handles redirect in exception handler
 * for unauthorized requests
 */
Route::redirect('login', '/guest/login')
    ->name('login');

Route::middleware(['web', 'auth'])->group(function () {
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
        })->name('guestHome');
    });
});