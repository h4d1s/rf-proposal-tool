<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\ServiceTemplateItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServiceTemplateItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permission = Permission::with('roles')->where('slug', 'view_service_template_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ServiceTemplateItem $serviceTemplateItem): bool
    {
        $permission = Permission::with('roles')->where('slug', 'view_service_template_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permission = Permission::with('roles')->where('slug', 'create_service_template_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ServiceTemplateItem $serviceTemplateItem): bool
    {
        $permission = Permission::with('roles')->where('slug', 'edit_service_template_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ServiceTemplateItem $serviceTemplateItem): bool
    {
        $permission = Permission::with('roles')->where('slug', 'delete_service_template_item')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ServiceTemplateItem $serviceTemplateItem): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ServiceTemplateItem $serviceTemplateItem): bool
    {
        $permission = Permission::with('roles')->where('slug', 'delete_service_template_item')->first();

        return $user->hasPermissionTo($permission);
    }
}
