<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::findOrFail(1);
        $roleAdmin = Role::where('name', RoleEnum::Admin->value)->firstOrFail();
        $admin->roles()->save($roleAdmin);

        $roleMember = Role::where('name', RoleEnum::Member->value)->firstOrFail();
        User::whereNot('id', 1)
            ->chunk(500, function (Collection $members) use ($roleMember) {
                foreach ($members as $member) {
                    $member->roles()->save($roleMember);
                }
            });
    }
}
