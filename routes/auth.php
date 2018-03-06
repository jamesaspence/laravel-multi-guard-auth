<?php
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('logout', 'Auth\LogoutController@logout')->name('logout');
});

Route::prefix('guest')->group(function () {
    Route::namespace('Login')->group(function () {
        Route::get('login', 'GuestLoginController@showLoginForm')->name('guest-login');
        Route::post('login', 'GuestLoginController@login');
    });
    Route::namespace('Register')->group(function () {
        Route::get('register', 'GuestLoginController@showRegistrationForm')->name('guest-register');
        Route::post('register', 'GuestLoginController@register')->name('guest-register');
    });
});