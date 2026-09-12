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
     * List is pre-filtered per role in the query; policy just gates access.
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

    /**
     * Determine whether the user can complete lessons within a tutorial.
     *
     * Same access rules as view():
     *   - admin   → bypassed in before()
     *   - user    → always yes (enrollment is checked separately for
     *               write operations but any user can complete lessons
     *               in tutorials they can view)
     *   - student → only if the tutorial is assigned to them
     */
    public function complete(User $user, Tutorial $tutorial): bool
    {
        return $this->view($user, $tutorial);
    }
}
