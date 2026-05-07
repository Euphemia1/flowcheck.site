<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organisation::where('slug', 'corelink-construction')->first();
        if (!$org) return;

        $users = [
            ['email' => 'admin@corelink.co.zm',       'name' => 'Admin Corelink',       'role' => 'org_admin'],
            ['email' => 'procurement@corelink.co.zm',  'name' => 'Mwansa Procurement',   'role' => 'procurement_officer'],
            ['email' => 'manager@corelink.co.zm',      'name' => 'Bwalya Manager',       'role' => 'procurement_manager'],
            ['email' => 'finance@corelink.co.zm',      'name' => 'Chanda Finance',       'role' => 'finance_officer'],
            ['email' => 'cfo@corelink.co.zm',          'name' => 'Mutale CFO',           'role' => 'cfo'],
            ['email' => 'head@corelink.co.zm',         'name' => 'Temwani DeptHead',     'role' => 'department_head'],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(['email' => $data['email']], [
                'id'                => Str::uuid(),
                'organisation_id'   => $org->id,
                'name'              => $data['name'],
                'email'             => $data['email'],
                'password'          => bcrypt('password'),
                'email_verified_at' => now(),
                'is_active'         => true,
            ]);
            $user->syncRoles([$data['role']]);
        }
    }
}
