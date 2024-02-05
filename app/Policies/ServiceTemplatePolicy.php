<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\ServiceTemplate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceTemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'view_service_template')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ServiceTemplate $serviceTemplate)
    {
        $permission = Permission::with('roles')->where('slug', 'view_service_template')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $serviceTemplate->team->id === $team_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'create_service_template')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ServiceTemplate $serviceTemplate)
    {
        $permission = Permission::with('roles')->where('slug', 'edit_service_template')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $serviceTemplate->team->id === $team_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ServiceTemplate $serviceTemplate)
    {
        $permission = Permission::with('roles')->where('slug', 'delete_service_template')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $serviceTemplate->team->id === $team_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ServiceTemplate $serviceTemplate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ServiceTemplate $serviceTemplate)
    {
        $permission = Permission::with('roles')->where('slug', 'delete_service_template')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $serviceTemplate->team->id === $team_id;
    }
}
