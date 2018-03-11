<?php


namespace Tests\Feature;


use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    public function testGuestLogoutSuccess()
    {
        $this->createAndSetUser(Role::GUEST_ROLE);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('guest-login'));
    }

    public function testHostLogoutSuccess()
    {
        $this->createAndSetUser(Role::HOST_ROLE);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('host-login'));
    }

    public function testAdminLogoutSuccess()
    {
        $this->createAndSetUser(Role::ADMIN_ROLE);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('admin-login'));
    }

    private function createAndSetUser($roleName)
    {
        /** @var Role $role */
        $role = factory(Role::class)->create([
            'name' => $roleName
        ]);

        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => 'test' . Str::ucfirst($roleName) . '@jamesspencemilwaukee.com'
        ]);
        $user->roles()->save($role);

        \Auth::setUser($user);
    }

}