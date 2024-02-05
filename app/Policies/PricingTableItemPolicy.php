<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\PricingTableItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PricingTableItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permission = Permission::with('roles')->where('slug', 'view_pricing_table_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PricingTableItem $pricingTableItem): bool
    {
        $permission = Permission::with('roles')->where('slug', 'view_pricing_table_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permission = Permission::with('roles')->where('slug', 'create_pricing_table_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PricingTableItem $pricingTableItem): bool
    {
        $permission = Permission::with('roles')->where('slug', 'edit_pricing_table_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PricingTableItem $pricingTableItem): bool
    {
        $permission = Permission::with('roles')->where('slug', 'delete_pricing_table_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PricingTableItem $pricingTableItem): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PricingTableItem $pricingTableItem): bool
    {
        $permission = Permission::with('roles')->where('slug', 'delete_pricing_table_item')->first();

        return $user->hasPermissionTo($permission);
    }
}
