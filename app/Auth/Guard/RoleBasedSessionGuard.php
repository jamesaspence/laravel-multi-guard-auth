<?php


namespace Guard;

use Illuminate\Auth\SessionGuard;

class RoleBasedSessionGuard extends SessionGuard
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'login_role_' . sha1(static::class);
    }

}