<?php


namespace Tests\Feature;


use App\Models\Role;

class HostLoginTest extends LoginTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getCorrectRole(): string
    {
        return Role::HOST_ROLE;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormUrl(): string
    {
        return route('host-login');
    }

    /**
     * {@inheritdoc}
     */
    protected function getSuccessUrl(): string
    {
        return route('host-home');
    }
}