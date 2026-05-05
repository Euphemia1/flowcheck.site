<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::updateOrCreate(
            ['name' => 'Starter'],
            [
                'price_monthly' => 299,
                'max_users' => 5,
                'max_vendors' => 20,
                'features' => [
                    'basic_procurement' => true,
                    'approval_workflows' => false,
                    'invoicing' => false,
                    'analytics' => false,
                ]
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Growth'],
            [
                'price_monthly' => 999,
                'max_users' => 25,
                'max_vendors' => 100,
                'features' => [
                    'basic_procurement' => true,
                    'approval_workflows' => true,
                    'invoicing' => true,
                    'analytics' => true,
                    'three_way_matching' => false,
                ]
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Enterprise'],
            [
                'price_monthly' => 2999,
                'max_users' => null,
                'max_vendors' => null,
                'features' => [
                    'basic_procurement' => true,
                    'approval_workflows' => true,
                    'invoicing' => true,
                    'analytics' => true,
                    'three_way_matching' => true,
                    'tender_management' => true,
                    'contract_management' => true,
                    'api_access' => true,
                ]
            ]
        );
    }
}
