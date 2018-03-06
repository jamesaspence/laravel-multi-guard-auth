<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expectedRoles = [
            'guest',
            'host',
            'admin'
        ];

        $expectedEmails = $this->generateTestEmails($expectedRoles);
        /** @var Collection $users */
        $users = User::whereIn('email', $expectedEmails)
            ->get();

        foreach ($expectedRoles as $expectedRole) {
            $user = $users->first(function (User $user) use ($expectedRole) {
                $email = $this->generateTestEmail($expectedRole);
                return $user->email === $email &&
                    !is_null($user->roles) &&
                    !$user->roles->isEmpty() &&
                    !is_null($user->roles->first(function (Role $role) use ($expectedRole) {
                        return $role->name === $expectedRole;
                    }));
            });

            if (is_null($user)) {
                /** @var User $user */
                $user = factory(User::class)->create([
                    'email' => $this->generateTestEmail($expectedRole)
                ]);
                $user->roles()->save(Role::where('name', '=', $expectedRole)->first());
            }
        }

        $this->command->info('Users with roles seeded.');
    }

    private function generateTestEmails($roles)
    {
        $emails = [];
        foreach ($roles as $role) {
            $emails[] = $this->generateTestEmail($role);
        }

        return $emails;
    }

    private function generateTestEmail($role)
    {
        return 'test' . Str::ucfirst($role) . '@jamesspencemilwaukee.com';
    }
}
