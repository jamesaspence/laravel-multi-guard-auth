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

    abstract protected function getCorrectRole(): string;

    abstract protected function getFormUrl(): string;

    abstract protected function getSuccessUrl(): string;

    protected function getCorrectPassword(): string
    {
        return 'secret';
    }

    protected function getCorrectEmail(): string
    {
        return 'test' . Str::ucfirst($this->getCorrectRole()) . '@jamesspencemilwaukee.com';
    }

    protected function createUser($email = null, $role = null): User
    {
        $email = $email ?? $this->getCorrectEmail();

        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => $email
        ]);

        $user->roles()->save($this->createRole($role));

        return $user;
    }

    protected function createRole($role = null): Role
    {
        $role = $role ?? $this->getCorrectRole();

        return factory(Role::class)->create([
            'name' => $role
        ]);
    }

}