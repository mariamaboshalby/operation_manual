<?php

namespace App\Policies;

use App\Models\Tutorial;
use App\Models\User;

class TutorialPolicy
{
    /**
     * Admins bypass all policy checks entirely.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the tutorials list.
     *
     * - admin   → bypassed in before()
     * - user    → always yes
     * - student → always yes (list is pre-filtered in the query)
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a specific tutorial.
     *
     * - admin   → bypassed in before()
     * - user    → always yes
     * - student → only if the tutorial is assigned to them
     */
    public function view(User $user, Tutorial $tutorial): bool
    {
        if ($user->isStudent()) {
            return $user->tutorials()->where('tutorials.id', $tutorial->id)->exists();
        }

        // role = 'user'
        return true;
    }
}
