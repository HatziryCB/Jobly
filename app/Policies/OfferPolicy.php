<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Offer $offer): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Offer $offer)
    {
        return $user->id === $offer->employer_id;
    }

    public function delete(User $user, Offer $offer): bool
    {
        return false;
    }

    public function restore(User $user, Offer $offer): bool
    {
        return false;
    }

    public function forceDelete(User $user, Offer $offer): bool
    {
        return false;
    }
}
