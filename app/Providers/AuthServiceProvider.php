<?php

namespace App\Providers;

use App\Auth\Provider\RoleBasedUserProvider;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Container\Container;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Guard\RoleBasedSessionGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param AuthManager $auth
     * @return void
     */
    public function boot(AuthManager $auth)
    {
        $this->registerPolicies();

        $this->registerRoleBasedAuth($auth);
    }

    private function registerRoleBasedAuth(AuthManager $auth)
    {
        $auth->provider('role', function (Container $app, array $config) {
            return new RoleBasedUserProvider($app->make(Hasher::class), User::class, $config['role']);
        });

        $auth->extend('role', function (Container $app, $name, array $config) use ($auth) {
            $guard = new RoleBasedSessionGuard(
                $name,
                $auth->createUserProvider($config['provider']),
                $app->make(Session::class),
                $app->make(Request::class)
            );
            /*
             * Due to issues with the cookie jar not being set properly, we have to set it here.
             * This ensures any interactions with cookies (such as a remember token) work properly.
             */
            $guard->setCookieJar($app['cookie']);
            return $guard;
        });
    }
}
