<?php


namespace Tests\Feature;


use App\Models\Role;

class GuestRegistrationTest extends RegistrationTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getCorrectRole(): string
    {
        return Role::GUEST_ROLE;
    }

    protected function getFormUrl(): string
    {
        return route('guest-register');
    }

    protected function getSuccessUrl(): string
    {
        return route('guest-home');
    }
}