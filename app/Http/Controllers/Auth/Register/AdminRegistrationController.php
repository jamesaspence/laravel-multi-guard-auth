<?php


namespace App\Http\Controllers\Auth\Register;


use App\Models\Role;

class AdminRegistrationController extends AbstractRegistrationController
{

    /**
     * {@inheritdoc}
     */
    public function getAuthViewName(): string
    {
        return 'auth.admin.register';
    }

    /**
     * {@inheritdoc}
     */
    public function getGuardName(): string
    {
        return Role::ADMIN_ROLE;
    }

    /**
     * Retrieves the redirect to link after successful auth.
     *
     * @return string
     */
    public function redirectTo(): string
    {
        return route('admin-home');
    }
}