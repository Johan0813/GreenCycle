<?php

namespace App\Policies;

use App\Models\Trees;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TreesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Trees $trees): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Trees $trees): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Trees $trees): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Trees $trees): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Trees $trees): bool
    {
        return false;
    }

    /**
 * Determine whether the user can care for the tree.
 */

    public function care(User $user, Trees $trees): bool
    {
        return $user->id_user === $trees->id_user;
    }
}
