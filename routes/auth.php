<?php
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('logout', 'Auth\LogoutController@logout')->name('logout');
});

Route::prefix('guest')->group(function () {
    Route::get('login', 'GuestAuthController@showLoginForm')->name('guest-login');
    Route::post('login', 'GuestAuthController@login');
    Route::get('register', 'GuestAuthController@showRegistrationForm')->name('guest-register');
    Route::post('register', 'GuestAuthController@register')->name('guest-register');
});