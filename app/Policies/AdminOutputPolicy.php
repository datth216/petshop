<?php

namespace App\Policies;

use App\Output;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminOutputPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Output  $output
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.list-output'));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.add-output'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Output  $output
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.edit-output'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Output  $output
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.delete-output'));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Output  $output
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Output  $output
     * @return mixed
     */
    public function forceDelete(User $user, Output $output)
    {
        //
    }
}
