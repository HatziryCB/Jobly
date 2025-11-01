<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Access\Response;

class UserProfilePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, UserProfile $userProfile): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, UserProfile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    public function delete(User $user, UserProfile $userProfile): bool
    {
        return false;
    }

    public function restore(User $user, UserProfile $userProfile): bool
    {
        return false;
    }

    public function forceDelete(User $user, UserProfile $userProfile): bool
    {
        return false;
    }
}
