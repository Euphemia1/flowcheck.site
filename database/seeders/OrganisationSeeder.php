<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganisationSeeder extends Seeder
{
    public function run(): void
    {
        $professional = Plan::where('name', 'Professional')->first();
        $starter      = Plan::where('name', 'Starter')->first();

        Organisation::firstOrCreate(['slug' => 'corelink-construction'], [
            'id'       => Str::uuid(),
            'name'     => 'Corelink Construction Ltd',
            'slug'     => 'corelink-construction',
            'plan_id'  => $professional->id,
            'industry' => 'construction',
            'country'  => 'ZM',
            'currency' => 'ZMW',
            'settings' => ['mfa_enforcement' => false, 'si68_compliance' => true, 'fiscal_year_start' => 1],
        ]);

        Organisation::firstOrCreate(['slug' => 'zambia-procurement-solutions'], [
            'id'       => Str::uuid(),
            'name'     => 'Zambia Procurement Solutions',
            'slug'     => 'zambia-procurement-solutions',
            'plan_id'  => $starter->id,
            'industry' => 'other',
            'country'  => 'ZM',
            'currency' => 'ZMW',
            'settings' => ['mfa_enforcement' => false, 'si68_compliance' => false, 'fiscal_year_start' => 1],
        ]);
    }
}
