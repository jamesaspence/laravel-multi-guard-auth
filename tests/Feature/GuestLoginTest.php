<?php

namespace Tests\Feature;


use App\Models\Role;

class GuestLoginTest extends LoginTestCase
{

    /**
     * {@inheritdoc}
     */
    protected function getCorrectRole(): string
    {
        return Role::GUEST_ROLE;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormUrl(): string
    {
        return route('guest-login');
    }

    /**
     * {@inheritdoc}
     */
    protected function getSuccessUrl(): string
    {
        return route('guest-home');
    }
}
