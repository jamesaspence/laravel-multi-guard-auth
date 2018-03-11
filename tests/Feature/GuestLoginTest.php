<?php

namespace Tests\Feature;


use App\Models\Role;

class GuestLoginTest extends TestAuthCase
{
    private $guestHomeUrl = '/guest/home';
    private $loginUrl = '/guest/login';
    private $correctPassword = 'secret';

    public function testGuestHomeRedirect()
    {
        $response = $this->get($this->guestHomeUrl);

        $response->assertRedirect('http://multiguard.test/login');
    }

    public function testGuestLoginValidation()
    {
        $response = $this->post($this->loginUrl);
        $response->assertRedirect('/')
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function testGuestLoginIncorrectEmail()
    {
        $incorrectEmail = 'incorrectEmail@jamesspencemilwaukee.com';
        $this->createUser();

        $response = $this->post($this->loginUrl, [
            'email' => $incorrectEmail,
            'password' => $this->correctPassword
        ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors(['email']);
    }

    public function testGuestLoginIncorrectPassword()
    {
        $this->createUser();

        $response = $this->post($this->loginUrl, [
            'email' => $this->getCorrectEmail(),
            'password' => 'incorrectPassword'
        ]);
        $response->assertRedirect('/')
            ->assertSessionHasErrors(['email']);
    }

    public function testGuestLoginIncorrectLoginType()
    {
        $incorrectEmail = 'testAdmin@jamesspencemilwaukee.com';
        $this->createUser($incorrectEmail, 'admin');

        $response = $this->post($this->loginUrl, [
            'email' => $incorrectEmail,
            'password' => $this->correctPassword
        ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors(['email']);
    }

    public function testGuestLoginSuccess()
    {
        $this->createUser();

        $response = $this->post($this->loginUrl, [
            'email' => $this->getCorrectEmail(),
            'password' => $this->correctPassword
        ]);

        $response->assertRedirect($this->guestHomeUrl);
        //TODO find better way to write this test
    }

    /**
     * {@inheritdoc}
     */
    protected function getCorrectRole(): string
    {
        return Role::GUEST_ROLE;
    }
}
