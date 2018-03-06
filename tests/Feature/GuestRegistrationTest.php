<?php


namespace Tests\Feature;


use App\Models\User;

class GuestRegistrationTest extends TestAuthCase
{

    private $registerUrl = '/guest/register';

    public function testRegistrationValidation()
    {
        $response = $this->post($this->registerUrl);

        $response->assertStatus(422)
            ->assertSessionHasErrors([
                'name',
                'email',
                'password',
                'confirm_password'
            ]);
    }

    public function testRegistrationEmailInUse()
    {
        $this->createUser();

        $response = $this->post($this->registerUrl, [
            'name' => $this->faker()->name(),
            'email' => $this->getCorrectEmail(),
            'password' => 'secret',
            'confirm_password' => 'secret'
        ]);

        $response->assertStatus(422)
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
            'confirm_password' => 'notSecret'
        ]);

        $response->assertStatus(422)
            ->assertSessionHasErrors([
                'password',
                'confirm_password'
            ]);
    }

    public function testRegistrationSuccess()
    {
        $name = $this->faker()->name();
        $response = $this->post($this->registerUrl, [
            'name' => $name,
            'email' => $this->getCorrectEmail(),
            'password' => 'secret',
            'confirm_password' => 'secret'
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
        return 'guest';
    }
}