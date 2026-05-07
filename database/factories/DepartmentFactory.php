<?php

namespace Database\Factories;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        $names = ['Engineering', 'Finance', 'Operations', 'HR', 'Procurement', 'IT', 'Site Works', 'Administration'];
        return [
            'name'            => $this->faker->unique()->randomElement($names),
            'code'            => strtoupper($this->faker->lexify('???')),
            'organisation_id' => Organisation::factory(),
        ];
    }
}
