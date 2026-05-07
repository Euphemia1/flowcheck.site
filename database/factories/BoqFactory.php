<?php

namespace Database\Factories;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoqFactory extends Factory
{
    public function definition(): array
    {
        $org = Organisation::factory()->create();
        return [
            'organisation_id'    => $org->id,
            'prepared_by'        => User::factory(['organisation_id' => $org->id]),
            'boq_number'         => 'BOQ-' . now()->year . '-' . $this->faker->numerify('#####'),
            'project_name'       => $this->faker->bs() . ' Project',
            'project_location'   => $this->faker->city() . ', Zambia',
            'procurement_method' => $this->faker->randomElement(['direct', 'rfq', 'open_tender']),
            'status'             => 'draft',
            'total_amount'       => $this->faker->randomFloat(2, 10000, 5000000),
            'items'              => [
                ['description' => 'Site Clearance', 'category' => 'Preliminaries', 'unit' => 'm2', 'quantity' => 500, 'unit_rate' => 25],
                ['description' => 'Concrete Foundations', 'category' => 'Concrete Works', 'unit' => 'm3', 'quantity' => 80, 'unit_rate' => 850],
            ],
        ];
    }
}
