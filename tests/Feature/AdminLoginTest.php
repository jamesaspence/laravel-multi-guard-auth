<?php


namespace Tests\Feature;


use App\Models\Role;

class AdminLoginTest extends LoginTestCase
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
        return route('admin-login');
    }

    /**
     * {@inheritdoc}
     */
    protected function getSuccessUrl(): string
    {
        return route('admin-home');
    }
}