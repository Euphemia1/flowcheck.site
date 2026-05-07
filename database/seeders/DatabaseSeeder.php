<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            PlanSeeder::class,
            OrganisationSeeder::class,
            UserSeeder::class,
            DepartmentSeeder::class,
            BudgetLineSeeder::class,
            VendorSeeder::class,
            WorkflowSeeder::class,
        ]);
    }
}
