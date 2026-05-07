<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganisationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'    => $this->faker->company(),
            'plan_id' => Plan::inRandomOrder()->first()?->id ?? Plan::factory(),
            'address' => $this->faker->address(),
            'phone'   => $this->faker->phoneNumber(),
            'email'   => $this->faker->companyEmail(),
        ];
    }
}
