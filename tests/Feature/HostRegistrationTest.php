<?php


namespace Tests\Feature;


use App\Models\Role;

class HostRegistrationTest extends RegistrationTestCase
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
        return route('host-register');
    }

    /**
     * {@inheritdoc}
     */
    protected function getSuccessUrl(): string
    {
        return route('host-home');
    }
}