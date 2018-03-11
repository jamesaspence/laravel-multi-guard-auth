<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string email
 * @property Collection roles
 * @property string name
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleName): bool
    {
        return $this->findRoles([$roleName])->isNotEmpty();
    }

    public function hasAtLeastOneRole(array $roleNames): bool
    {
        return $this->findRoles($roleNames, true)->isNotEmpty();
    }

    public function hasAllRoles(array $roleNames): bool
    {
        return count($this->findRoles($roleNames)) === count($roleNames);
    }

    private function findRoles(array $roleNames, bool $firstMatch = false)
    {
        $callback = function (Role $role) use ($roleNames) {
            return in_array($role->name, $roleNames);
        };

        return $firstMatch ?
            $this->roles->first($callback) :
            $this->roles->filter($callback);
    }
}
