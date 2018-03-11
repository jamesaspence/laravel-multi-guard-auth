<?php


namespace App\Http\Controllers\Auth\Register;


use App\Models\Role;

class HostRegistrationController extends AbstractRegistrationController
{

    /**
     * {@inheritdoc}
     */
    public function getAuthViewName(): string
    {
        return 'auth.host.register';
    }

    /**
     * {@inheritdoc}
     */
    public function getGuardName(): string
    {
        return Role::HOST_ROLE;
    }

    /**
     * Retrieves the redirect to link after successful auth.
     *
     * @return string
     */
    public function redirectTo(): string
    {
        return route('host-home');
    }
}