<?php


namespace App\Http\Controllers\Auth\Login;


use App\Models\Role;

class AdminLoginController extends AbstractLoginController
{
    /**
     * {@inheritdoc}
     */
    public function getGuardName(): string
    {
        return Role::ADMIN_ROLE;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthViewName(): string
    {
        return 'auth.admin.login';
    }

    /**
     * {@inheritdoc}
     */
    public function redirectTo(): string
    {
        return route('admin-home');
    }
}