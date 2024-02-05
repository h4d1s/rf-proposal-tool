<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_class = strtolower(class_basename(User::class));
        $team_class = strtolower(class_basename(Team::class));

        $admin = User::with("permissions")->findOrFail(1);
        $operations = ['view', 'create', 'edit', 'delete'];
        $admin_permissions = [];

        foreach ($operations as $operation) {
            $admin_permissions[] = Permission::where('slug', $operation . '_' . $user_class)->first()->id;
            $admin_permissions[] = Permission::where('slug', $operation . '_' . $team_class)->first()->id;
        }
        
        $membersQuery = User::with("permissions")->whereNot('id', 1);
        $all_permissions_without_admin = Permission::whereNotIn('id', $admin_permissions)->get();
        
        $plucked_ids = $all_permissions_without_admin->pluck('id');
        $all_permissions = array_merge($plucked_ids->all(), $admin_permissions);

        $admin->permissions()->sync($all_permissions);
        $membersQuery->chunk(500, function (Collection $members) use ($all_permissions_without_admin) {
            foreach ($members as $member) {
                $member->permissions()->sync($all_permissions_without_admin);
                $member->save();
            }
        });
    }
}
