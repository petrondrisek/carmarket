<?php
namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Checks whether a user has a specific permission.
     * 
     * @param User $user
     * @param string $permission
     * 
     * @return bool
     */
    public static function checkPermission(User $user, string $permission): bool
    {
        if(!$user) return false;

        $permissions = json_decode($user->permissions);
        return in_array($permission, $permissions);
    }
}