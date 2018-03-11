<?php


namespace App\Http\Controllers\Auth\Login;


use App\Models\Role;

class HostLoginController extends AbstractLoginController
{
    /**
     * {@inheritdoc}
     */
    public function getGuardName(): string
    {
        return Role::HOST_ROLE;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthViewName(): string
    {
        return 'auth.host.login';
    }

    /**
     * {@inheritdoc}
     */
    public function redirectTo(): string
    {
        return route('host-home');
    }
}