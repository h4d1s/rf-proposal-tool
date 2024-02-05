<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'view_product')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Product $product)
    {
        $permission = Permission::with('roles')->where('slug', 'view_product')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $product->team_id === $team_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'create_product')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Product $product)
    {
        $permission = Permission::with('roles')->where('slug', 'edit_product')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $product->team_id === $team_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Product $product)
    {
        $permission = Permission::with('roles')->where('slug', 'delete_product')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $product->team_id === $team_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Product $product)
    {
        $permission = Permission::with('roles')->where('slug', 'delete_product')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $product->team_id === $team_id;
    }
}
