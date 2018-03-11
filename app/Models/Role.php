<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 */
class Role extends Model
{
    const ADMIN_ROLE = 'admin';
    const HOST_ROLE = 'host';
    const GUEST_ROLE = 'guest';
    const ROLES = [
        self::ADMIN_ROLE,
        self::HOST_ROLE,
        self::GUEST_ROLE
    ];

    public $timestamps = false;
}
