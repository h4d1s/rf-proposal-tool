<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_permissions = Permission::all();

        // Admin
        $admin = Role::where('name', RoleEnum::Admin->value)->firstOrFail();
        $admin->permissions()->attach($all_permissions);

        // Member
        $member_permissions = $all_permissions->filter(function ($permission) {
            return !(
                str_contains($permission->slug, 'user') ||
                str_contains($permission->slug, 'role') ||
                str_contains($permission->slug, 'setting') ||
                str_contains($permission->slug, 'team')
            );
        });
        $member = Role::where('name', RoleEnum::Member->value)->firstOrFail();
        $member->permissions()->attach($member_permissions);
    }
}
