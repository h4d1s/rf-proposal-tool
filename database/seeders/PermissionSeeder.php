<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Collection;
use App\Models\Company;
use App\Models\Discussion;
use App\Models\Note;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client_class = class_basename(Client::class);
        $company_class = class_basename(Company::class);
        $collection_class = class_basename(Collection::class);
        $discussion_class = class_basename(Discussion::class);
        $product_class = class_basename(Product::class);
        $project_class = class_basename(Project::class);
        $proposal_class = class_basename(Proposal::class);
        $role_class = class_basename(Role::class);
        $permission_class = class_basename(Permission::class);
        $service_template_class = 'Service Template';
        $service_template_item_class = 'Service Template Item';
        $note_class = class_basename(Note::class);
        $pricing_table_class = 'Pricing Table';
        $pricing_table_item_class = 'Pricing Table Item';
        $user_class = class_basename(User::class);
        $email_template_class = 'Email Template';
        $setting_class = class_basename(Setting::class);
        $team_class = class_basename(Team::class);

        $permission_names = [];
        $entities = [
            $client_class,
            $company_class,
            $collection_class,
            $discussion_class,
            $product_class,
            $project_class,
            $proposal_class,
            $role_class,
            $permission_class,
            $service_template_class,
            $service_template_item_class,
            $note_class,
            $pricing_table_class,
            $pricing_table_item_class,
            $user_class,
            $email_template_class,
            $setting_class,
            $team_class
        ];
        foreach ($entities as $entity) {
            $entity_name = strtolower($entity);
            $permission_names[] = 'View ' . $entity_name;
            $permission_names[] = 'Create ' . $entity_name;
            $permission_names[] = 'Edit ' . $entity_name;
            $permission_names[] = 'Delete ' . $entity_name;
        }

        $permissions = [];
        foreach ($permission_names as $key => $permission) {
            $permissions[$key]['name'] = $permission;
            $permissions[$key]['slug'] = str_replace(' ', '_', strtolower($permission));
        }

        Permission::insert($permissions);
    }
}
