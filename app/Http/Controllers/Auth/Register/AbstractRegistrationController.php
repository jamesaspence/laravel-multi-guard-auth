<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Auth\HandlesRoleBasedAuth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;

abstract class AbstractRegistrationController extends Controller implements HandlesRoleBasedAuth
{
    /*
    |--------------------------------------------------------------------------
    | Registration Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * {@inheritdoc}
     */
    public function showRegistrationForm()
    {
        return view($this->getAuthViewName());
    }

    /**
     * {@inheritdoc}
     */
    protected function guard()
    {
        return \Auth::guard($this->getGuardName());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
