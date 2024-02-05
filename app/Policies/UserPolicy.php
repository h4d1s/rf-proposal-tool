<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'view_user')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        if ($user->id === $model->id) {
            return true;
        }

        $permission = Permission::with('roles')->where('slug', 'view_user')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'create_user')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        if ($user->id === $model->id) {
            return true;
        }

        $permission = Permission::with('roles')->where('slug', 'update_user')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        $permission = Permission::with('roles')->where('slug', 'delete_user')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        $permission = Permission::with('roles')->where('slug', 'delete_user')->first();

        return $user->hasPermissionTo($permission);
    }
}
