<?php

namespace Database\Seeders;

use App\Models\BudgetLine;
use App\Models\Department;
use App\Models\Organisation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BudgetLineSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organisation::where('slug', 'corelink-construction')->first();
        if (!$org) return;

        $fiscalYear = now()->year;

        foreach (Department::where('organisation_id', $org->id)->get() as $dept) {
            BudgetLine::firstOrCreate(
                ['organisation_id' => $org->id, 'department_id' => $dept->id, 'fiscal_year' => $fiscalYear],
                [
                    'id'               => Str::uuid(),
                    'organisation_id'  => $org->id,
                    'department_id'    => $dept->id,
                    'fiscal_year'      => $fiscalYear,
                    'category'         => 'General',
                    'allocated_amount' => $dept->budget_allocated ?? 1000000,
                    'committed_amount' => 0,
                    'spent_amount'     => $dept->budget_used ?? 0,
                ]
            );
        }
    }
}
