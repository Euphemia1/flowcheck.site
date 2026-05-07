<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::updateOrCreate(['name' => 'Starter'], [
            'price_monthly' => 500,
            'max_users'     => 5,
            'max_vendors'   => 20,
            'features'      => ['purchase_requests' => true, 'invoices' => true, 'vendors' => true, 'basic_reports' => true, 'approval_workflows' => false, 'tenders' => false, 'boqs' => false],
        ]);

        Plan::updateOrCreate(['name' => 'Professional'], [
            'price_monthly' => 1500,
            'max_users'     => 25,
            'max_vendors'   => 100,
            'features'      => ['purchase_requests' => true, 'purchase_orders' => true, 'rfqs' => true, 'grns' => true, 'invoices' => true, 'vendors' => true, 'contracts' => true, 'budgets' => true, 'reports' => true, 'excel_export' => true, 'approval_workflows' => true, 'tenders' => false, 'boqs' => false],
        ]);

        Plan::updateOrCreate(['name' => 'Enterprise'], [
            'price_monthly' => 5000,
            'max_users'     => null,
            'max_vendors'   => null,
            'features'      => ['all_features' => true, 'tenders' => true, 'boqs' => true, 'mfa' => true, 'api_access' => true, 'priority_support' => true, 'custom_workflows' => true, 'three_way_matching' => true],
        ]);
    }
}
