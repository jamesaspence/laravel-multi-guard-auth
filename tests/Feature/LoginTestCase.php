<?php


namespace Tests\Feature;


abstract class LoginTestCase extends AuthTestCase
{
    abstract protected function getIncorrectRole(): string;

    public function testGuestHomeRedirect()
    {
        $response = $this->get($this->getSuccessUrl());

        $response->assertRedirect('http://multiguard.test/login');
    }

    public function testGuestLoginValidation()
    {
        $response = $this->post($this->getFormUrl());
        $response->assertRedirect('/')
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function testGuestLoginIncorrectEmail()
    {
        $incorrectEmail = 'incorrectEmail@jamesspencemilwaukee.com';
        $this->createUser();

        $response = $this->post($this->getFormUrl(), [
            'email' => $incorrectEmail,
            'password' => $this->getCorrectPassword()
        ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors(['email']);
    }

    public function testGuestLoginIncorrectPassword()
    {
        $this->createUser();

        $response = $this->post($this->getFormUrl(), [
            'email' => $this->getCorrectEmail(),
            'password' => 'incorrectPassword'
        ]);
        $response->assertRedirect('/')
            ->assertSessionHasErrors(['email']);
    }

    public function testGuestLoginIncorrectLoginType()
    {
        $incorrectEmail = 'testAdmin@jamesspencemilwaukee.com';
        $this->createUser($incorrectEmail, $this->getIncorrectRole());

        $response = $this->post($this->getFormUrl(), [
            'email' => $incorrectEmail,
            'password' => $this->getCorrectPassword()
        ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors(['email']);
    }

    public function testGuestLoginSuccess()
    {
        $this->createUser();

        $response = $this->post($this->getFormUrl(), [
            'email' => $this->getCorrectEmail(),
            'password' => $this->getCorrectPassword()
        ]);

        $response->assertRedirect($this->getSuccessUrl());
        //TODO find better way to write this test
    }
}