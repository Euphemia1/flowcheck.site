<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseRequestFactory extends Factory
{
    public function definition(): array
    {
        $org = Organisation::factory()->create();
        return [
            'organisation_id'        => $org->id,
            'department_id'          => Department::factory(['organisation_id' => $org->id]),
            'requested_by'           => User::factory(['organisation_id' => $org->id]),
            'pr_number'              => 'PR-' . now()->year . '-' . $this->faker->numerify('#####'),
            'title'                  => $this->faker->sentence(4),
            'description'            => $this->faker->paragraph(),
            'justification'          => $this->faker->sentence(),
            'priority'               => $this->faker->randomElement(['low', 'normal', 'high', 'urgent']),
            'status'                 => 'draft',
            'total_estimated_amount' => $this->faker->randomFloat(2, 500, 500000),
            'required_by_date'       => now()->addDays(rand(7, 60))->toDateString(),
        ];
    }
}
