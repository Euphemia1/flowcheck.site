<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Organisation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organisation::where('slug', 'corelink-construction')->first();
        if (!$org) return;

        $departments = [
            ['name' => 'Engineering',  'budget_allocated' => 5000000],
            ['name' => 'Finance',      'budget_allocated' => 2000000],
            ['name' => 'Operations',   'budget_allocated' => 8000000],
            ['name' => 'HR',           'budget_allocated' => 1500000],
            ['name' => 'Site Works',   'budget_allocated' => 12000000],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['organisation_id' => $org->id, 'name' => $dept['name']],
                array_merge($dept, ['id' => Str::uuid(), 'organisation_id' => $org->id, 'budget_used' => 0])
            );
        }
    }
}
