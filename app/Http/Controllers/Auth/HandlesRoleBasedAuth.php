<?php


namespace App\Http\Controllers\Auth;


/**
 * Defines a class that handles role based auth.
 * Can either be a login or registration controller.
 *
 * Interface HandlesRoleBasedAuth
 * @package App\Http\Controllers\Auth
 */
interface HandlesRoleBasedAuth
{
    /**
     * Retrieves the auth view's name.
     *
     * @return string
     */
    public function getAuthViewName(): string;

    /**
     * Retrieves the guard's name.
     *
     * @return string
     */
    public function getGuardName(): string;

    /**
     * Retrieves the redirect to link after successful auth.
     *
     * @return string
     */
    public function redirectTo(): string;
}