<?php

namespace Database\Factories;

use App\Models\Organisation;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    public function definition(): array
    {
        $org = Organisation::factory()->create();
        return [
            'organisation_id' => $org->id,
            'vendor_id'       => Vendor::factory(['organisation_id' => $org->id]),
            'created_by'      => User::factory(['organisation_id' => $org->id]),
            'po_number'       => 'PO-' . now()->year . '-' . $this->faker->numerify('#####'),
            'status'          => 'draft',
            'total_amount'    => $this->faker->randomFloat(2, 500, 500000),
            'delivery_date'   => now()->addDays(rand(7, 30))->toDateString(),
            'payment_terms'   => $this->faker->randomElement(['Net 30', 'Net 60', '50% upfront']),
        ];
    }
}
