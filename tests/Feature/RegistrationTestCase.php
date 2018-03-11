<?php


namespace Tests\Feature;


use App\Models\User;

abstract class RegistrationTestCase extends AuthTestCase
{
    public function testRegistrationFormLoads()
    {
        $response = $this->get($this->getFormUrl());

        $this->assertTrue($response->isSuccessful() || $response->isRedirection());
    }

    public function testRegistrationValidation()
    {
        $response = $this->post($this->getFormUrl());

        $response->assertRedirect('/')
            ->assertSessionHasErrors([
                'name',
                'email',
                'password'
            ]);
    }

    public function testRegistrationEmailInUse()
    {
        $this->createUser();

        $response = $this->post($this->getFormUrl(), [
            'name' => $this->faker()->name(),
            'email' => $this->getCorrectEmail(),
            'password' => $this->getCorrectPassword(),
            'password_confirmation' => $this->getCorrectPassword()
        ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);
    }

    public function testRegistrationPasswordsDoNotMatch()
    {
        $response = $this->post($this->getFormUrl(), [
            'name' => $this->faker()->name(),
            'email' => $this->getCorrectEmail(),
            'password' => $this->getCorrectPassword(),
            'password_confirmation' => 'notSecret'
        ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors([
                'password' => 'The password confirmation does not match.'
            ]);
    }

    public function testRegistrationSuccess()
    {
        $this->createRole($this->getCorrectRole());

        $name = $this->faker()->name();
        $response = $this->post($this->getFormUrl(), [
            'name' => $name,
            'email' => $this->getCorrectEmail(),
            'password' => $this->getCorrectPassword(),
            'password_confirmation' => $this->getCorrectPassword()
        ]);

        $this->assertTrue($response->isSuccessful() || $response->isRedirection());

        /** @var User $user */
        $user = User::where('email', '=', $this->getCorrectEmail())
            ->first();

        $this->assertEquals($name, $user->name);
    }

}