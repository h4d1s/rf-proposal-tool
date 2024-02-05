<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            TeamSeeder::class,
            TeamEmailTemplateSeeder::class,
            TeamProductSeeder::class,
            TeamCollectionSeeder::class,
            TeamSettingsSeeder::class,
            CollectionProductSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            TeamUserSeeder::class,
            TeamClientSeeder::class,
            TeamCompanySeeder::class,
            RoleUserSeeder::class,
            PermissionRoleSeeder::class,
            PermissionUserSeeder::class,
            ClientProjectSeeder::class,
            ClientAddressSeeder::class,
            CompanyProjectSeeder::class,
            CompanyAddressSeeder::class,
            ProposalStateSeeder::class,
            ProjectProposalSeeder::class,
            ProposalPricingTableSeeder::class,
            PricingTablePricingTableItemSeeder::class,
            ProposalNoteSeeder::class,
            ProposalDiscussionSeeder::class,
            ProposalProductSeeder::class,
            TeamServiceTemplateSeeder::class,
            ServiceTemplateServiceTemplateItemSeeder::class,
            ActivityTypeSeeder::class,
            ActivityClientSeeder::class,
            UserImageSeeder::class,
            ProductImageSeeder::class,
        ]);
    }
}
