<?php

namespace App\Policies;

use App\Models\EmailTemplate;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailTemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'view_email_template')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, EmailTemplate $emailTemplate)
    {
        $permission = Permission::with('roles')->where('slug', 'view_email_template')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $emailTemplate->team->id === $team_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $permission = Permission::with('roles')->where('slug', 'create_email_template')->first();

        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, EmailTemplate $emailTemplate)
    {
        $permission = Permission::with('roles')->where('slug', 'edit_email_template')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $emailTemplate->team->id === $team_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, EmailTemplate $emailTemplate)
    {
        $permission = Permission::where('slug', 'delete_email_template')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $emailTemplate->team->id === $team_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, EmailTemplate $emailTemplate)
    {
        $permission = Permission::where('slug', 'delete_email_template')->first();
        $team_id = $user->team->id;

        return $user->hasPermissionTo($permission) && $emailTemplate->team->id === $team_id;
    }
}
