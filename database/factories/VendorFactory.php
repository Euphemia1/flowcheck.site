<?php

namespace Database\Factories;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organisation_id'  => Organisation::factory(),
            'name'             => $this->faker->company() . ' Ltd',
            'email'            => $this->faker->companyEmail(),
            'phone'            => $this->faker->phoneNumber(),
            'address'          => $this->faker->address(),
            'zppa_reg_number'  => 'ZPPA-' . $this->faker->numerify('####-####'),
            'zppa_reg_class'   => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'is_approved'      => true,
        ];
    }
}
