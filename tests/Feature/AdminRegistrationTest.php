<?php


namespace Tests\Feature;


use App\Models\Role;

class AdminRegistrationTest extends RegistrationTestCase
{

    /**
     * {@inheritdoc}
     */
    protected function getCorrectRole(): string
    {
        return Role::ADMIN_ROLE;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormUrl(): string
    {
        return route('admin-register');
    }

    /**
     * {@inheritdoc}
     */
    protected function getSuccessUrl(): string
    {
        return route('admin-home');
    }
}