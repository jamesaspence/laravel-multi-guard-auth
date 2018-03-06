<?php


namespace App\Http\Controllers\Auth\Login;


use App\Models\Role;

class GuestLoginController extends AbstractLoginController
{
    /**
     * {@inheritdoc}
     */
    public function getGuardName(): string
    {
        return Role::GUEST_ROLE;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthViewName(): string
    {
        return 'auth.guestLogin';
    }
}