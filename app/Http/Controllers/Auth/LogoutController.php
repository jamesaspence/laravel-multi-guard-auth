<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class LogoutController extends Controller
{

    public function logout(Request $request, AuthManager $auth)
    {
        /** @var User $user */
        $user = $request->user();

        /** @var Role $firstRole */
        $firstRole = $user->roles->first();

        $roleName = is_null($firstRole) ? 'guest' : $firstRole->name;

        $routeName = $roleName . '-login';

        $redirectPath = route($routeName, [], false);

        $auth->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect($redirectPath);
    }

}