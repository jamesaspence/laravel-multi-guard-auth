<?php


namespace Tests\Feature;


use App\Models\Role;
use App\Models\User;

class GuestRegistrationTest extends TestAuthCase
{
    private $registerUrl = '/guest/register';

    public function testRegistrationFormLoads()
    {
        $response = $this->get($this->registerUrl);

        $this->assertTrue($response->isSuccessful() || $response->isRedirection());
    }

    public function testRegistrationValidation()
    {
        $response = $this->post($this->registerUrl);

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

        $response = $this->post($this->registerUrl, [
            'name' => $this->faker()->name(),
            'email' => $this->getCorrectEmail(),
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors([
                'email'
            ]);
    }

    public function testRegistrationPasswordsDoNotMatch()
    {
        $response = $this->post($this->registerUrl, [
            'name' => $this->faker()->name(),
            'email' => $this->getCorrectEmail(),
            'password' => 'secret',
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
        $response = $this->post($this->registerUrl, [
            'name' => $name,
            'email' => $this->getCorrectEmail(),
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertTrue($response->isSuccessful() || $response->isRedirection());

        /** @var User $user */
        $user = User::where('email', '=', $this->getCorrectEmail())
            ->first();

        $this->assertEquals($name, $user->name);
    }

    /**
     * {@inheritdoc}
     */
    protected function getCorrectRole(): string
    {
        return Role::GUEST_ROLE;
    }
}