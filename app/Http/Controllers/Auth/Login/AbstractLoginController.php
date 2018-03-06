<?php


namespace App\Http\Controllers\Auth\Login;


use App\Http\Controllers\Auth\HandlesRoleBasedAuth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

abstract class AbstractLoginController extends Controller implements HandlesRoleBasedAuth
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * {@inheritdoc}
     */
    public function redirectTo(): string
    {
        return route('home');
    }

    /**
     * {@inheritdoc}
     */
    protected function guard()
    {
        return \Auth::guard($this->getGuardName());
    }

    /**
     * {@inheritdoc}
     */
    public function showLoginForm()
    {
        return view($this->getAuthViewName());
    }
}