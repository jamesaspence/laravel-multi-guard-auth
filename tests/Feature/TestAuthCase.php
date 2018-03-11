<?php


namespace Tests\Feature;


use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

abstract class TestAuthCase extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function getCorrectEmail(): string
    {
        return 'test' . Str::ucfirst($this->getCorrectRole()) . '@jamesspencemilwaukee.com';
    }

    abstract protected function getCorrectRole(): string;

    protected function createUser($email = null, $role = null)
    {
        $email = !is_null($email) ?: $this->getCorrectEmail();
        $role = !is_null($role) ?: $this->getCorrectRole();

        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => $email
        ]);

        $role = factory(Role::class)->create([
            'name' => $role
        ]);

        $user->roles()->save($role);
    }

}