<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function superadmin(User $user)
    {
        return $user->user_role === UserRole::SUPER_ADMIN->value;
    }

    public function admin(User $user)
    {
        return $user->user_role === UserRole::ADMIN->value;
    }

    public function staff(User $user)
    {
        return $user->user_role === UserRole::STAFF->value;
    }

    public function customer(User $user)
    {
        return $user->user_role === UserRole::CUSTOMER->value;
    }
}
