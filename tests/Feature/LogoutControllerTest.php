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
        $this->runLogoutTest(Role::GUEST_ROLE);
    }

    public function testHostLogoutSuccess()
    {
        $this->runLogoutTest(Role::HOST_ROLE);
    }

    public function testAdminLogoutSuccess()
    {
        $this->runLogoutTest(Role::ADMIN_ROLE);
    }

    private function runLogoutTest($roleName)
    {
        $this->createAndSetUser($roleName);

        $this->assertNotNull(\Auth::user());

        $response = $this->post(route('logout'));

        $response->assertRedirect(route($roleName . '-login'));

        $this->assertNull(\Auth::user());
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