<?php

namespace App\Policies;

use App\Orderform;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminOrderformPolicy
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
     * @param  \App\Orderform  $orderform
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.list-orderform'));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.add-orderform'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Orderform  $orderform
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.edit-orderform'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Orderform  $orderform
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.delete-orderform'));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Orderform  $orderform
     * @return mixed
     */
    public function detail(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.detail-orderform'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Orderform  $orderform
     * @return mixed
     */
    public function forceDelete(User $user, Orderform $orderform)
    {
        //
    }
}
