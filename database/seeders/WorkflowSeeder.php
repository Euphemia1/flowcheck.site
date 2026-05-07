<?php

namespace Database\Seeders;

use App\Models\ApprovalWorkflow;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WorkflowSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organisation::where('slug', 'corelink-construction')->first();
        if (!$org) return;

        $manager = User::where('email', 'manager@corelink.co.zm')->first();
        $cfo     = User::where('email', 'cfo@corelink.co.zm')->first();
        $head    = User::where('email', 'head@corelink.co.zm')->first();

        // Standard PR workflow (< ZMW 50,000)
        ApprovalWorkflow::firstOrCreate(
            ['organisation_id' => $org->id, 'name' => 'Standard PR'],
            [
                'id'              => Str::uuid(),
                'organisation_id' => $org->id,
                'name'            => 'Standard PR',
                'department_id'   => null,
                'min_amount'      => 0,
                'max_amount'      => 49999.99,
                'steps'           => [
                    ['step' => 1, 'approver_type' => 'role', 'role' => 'department_head', 'user_id' => $head?->id],
                    ['step' => 2, 'approver_type' => 'role', 'role' => 'procurement_manager', 'user_id' => $manager?->id],
                ],
            ]
        );

        // High value PR workflow (>= ZMW 50,000)
        ApprovalWorkflow::firstOrCreate(
            ['organisation_id' => $org->id, 'name' => 'High Value PR'],
            [
                'id'              => Str::uuid(),
                'organisation_id' => $org->id,
                'name'            => 'High Value PR',
                'department_id'   => null,
                'min_amount'      => 50000.00,
                'max_amount'      => null,
                'steps'           => [
                    ['step' => 1, 'approver_type' => 'role', 'role' => 'department_head', 'user_id' => $head?->id],
                    ['step' => 2, 'approver_type' => 'role', 'role' => 'procurement_manager', 'user_id' => $manager?->id],
                    ['step' => 3, 'approver_type' => 'role', 'role' => 'cfo', 'user_id' => $cfo?->id],
                ],
            ]
        );
    }
}
