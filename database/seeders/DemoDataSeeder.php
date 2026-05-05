<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Department;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo organisation
        $plan = Plan::first();
        $org = Organisation::create([
            'id' => Str::uuid(),
            'name' => 'Copperbelt Mining Co',
            'slug' => 'copperbelt-mining',
            'plan_id' => $plan->id,
            'industry' => 'mining',
            'country' => 'ZM',
            'currency' => 'ZMW',
            'settings' => [
                'mfa_enforcement' => false,
                'si68_compliance' => true,
                'fiscal_year_start' => 1,
            ]
        ]);

        // Create departments
        $departments = [];
        foreach (['Operations', 'Finance', 'Procurement', 'HR'] as $name) {
            $departments[$name] = Department::create([
                'id' => Str::uuid(),
                'organisation_id' => $org->id,
                'name' => $name,
                'budget_allocated' => 1000000,
                'budget_used' => 250000,
            ]);
        }

        // Create users
        $orgAdmin = User::create([
            'id' => Str::uuid(),
            'organisation_id' => $org->id,
            'name' => 'John Admin',
            'email' => 'admin@copperbelt.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $orgAdmin->assignRole('org_admin');

        $procOfficer = User::create([
            'id' => Str::uuid(),
            'organisation_id' => $org->id,
            'name' => 'Jane Procurement',
            'email' => 'jane@copperbelt.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $procOfficer->assignRole('procurement_officer');

        $approver = User::create([
            'id' => Str::uuid(),
            'organisation_id' => $org->id,
            'name' => 'Bob Manager',
            'email' => 'bob@copperbelt.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $approver->assignRole('approver');

        $cfo = User::create([
            'id' => Str::uuid(),
            'organisation_id' => $org->id,
            'name' => 'Alice CFO',
            'email' => 'alice@copperbelt.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $cfo->assignRole('cfo');

        // Create vendors
        $vendors = [];
        foreach (['Global Supplies Ltd', 'Local Mining Equipment', 'Tech Solutions Africa'] as $name) {
            $vendors[] = Vendor::create([
                'id' => Str::uuid(),
                'organisation_id' => $org->id,
                'name' => $name,
                'contact_person' => 'John Doe',
                'email' => str_replace(' ', '_', strtolower($name)) . '@vendor.com',
                'phone' => '+260123456789',
                'address' => 'Lusaka, Zambia',
                'tax_pin' => '12345/0001/23',
                'payment_terms' => 'Net 30',
                'is_approved' => true,
                'performance_score' => 4.5,
            ]);
        }
    }
}
