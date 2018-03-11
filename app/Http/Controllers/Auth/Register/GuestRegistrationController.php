<?php


namespace App\Http\Controllers\Auth\Register;


use App\Models\Role;

class GuestRegistrationController extends AbstractRegistrationController
{

    /**
     * {@inheritdoc}
     */
    public function getAuthViewName(): string
    {
        return 'auth.register';
    }

    /**
     * {@inheritdoc}
     */
    public function getGuardName(): string
    {
        return Role::GUEST_ROLE;
    }

    /**
     * Retrieves the redirect to link after successful auth.
     *
     * @return string
     */
    public function redirectTo(): string
    {
        return route('guestHome');
    }
}