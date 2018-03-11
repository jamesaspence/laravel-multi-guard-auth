<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Role;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    /** @var User $user */
    $user = Auth::user();

    if (is_null($user) || $user->roles->isEmpty()) {
        return redirect(route('guest-login'));
    }

    /** @var Role $role */
    $role = $user->roles->first();

    return redirect(route($role->name . '-home'));
})->name('home');
