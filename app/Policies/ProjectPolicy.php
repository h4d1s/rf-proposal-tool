<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Permission;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'view_project')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Project $project)
    {
        $permission = Permission::with('roles')->where('slug', 'view_project')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $project->projectable->team->id === $team_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'create_project')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Project $project)
    {
        $permission = Permission::with('roles')->where('slug', 'edit_project')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $project->projectable->team->id === $team_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Project $project)
    {
        $permission = Permission::with('roles')->where('slug', 'delete_project')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $project->projectable->team->id === $team_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Project $project)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Project $project)
    {
        $permission = Permission::with('roles')->where('slug', 'delete_project')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $project->projectable->team->id === $team_id;
    }
}
