<?php

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Collection $roles */
        $roles = Role::all();

        $expectedRoles = ['guest', 'host', 'admin'];

        foreach ($expectedRoles as $expectedRole) {
            $role = $roles->first(function (Role $indvRole) use ($expectedRole) {
                return $expectedRole === $indvRole->name;
            });

            if (is_null($role)) {
                factory(Role::class)->create([
                    'name' => $expectedRole
                ]);
            }
        }

        $this->command->info('Roles seeded.');
    }
}
