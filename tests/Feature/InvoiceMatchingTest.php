<?php

use App\Models\Invoice;
use App\Models\Organisation;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Models\Vendor;
use App\Services\ThreeWayMatchingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    $this->seed(\Database\Seeders\PlanSeeder::class);

    $this->org    = Organisation::factory()->create();
    $this->user   = User::factory()->create(['organisation_id' => $this->org->id]);
    $this->user->assignRole('finance_officer');
    $this->vendor = Vendor::factory()->create(['organisation_id' => $this->org->id]);
});

it('matches invoice within 5% tolerance', function () {
    $service = new ThreeWayMatchingService();

    $result = $service->match(
        poAmount: 1000.00,
        grnAmount: 1000.00,
        invoiceAmount: 1040.00
    );

    expect($result['matched'])->toBeTrue();
    expect($result['variance_pct'])->toBeLessThanOrEqual(5.0);
});

it('fails match above 5% tolerance', function () {
    $service = new ThreeWayMatchingService();

    $result = $service->match(
        poAmount: 1000.00,
        grnAmount: 1000.00,
        invoiceAmount: 1060.00
    );

    expect($result['matched'])->toBeFalse();
    expect($result['variance_pct'])->toBeGreaterThan(5.0);
});

it('blocks invoice upload for unauthorized user', function () {
    $viewer = User::factory()->create(['organisation_id' => $this->org->id]);
    $viewer->assignRole('viewer');

    $po = PurchaseOrder::factory()->create([
        'organisation_id' => $this->org->id,
        'vendor_id'       => $this->vendor->id,
        'status'          => 'approved',
    ]);

    $this->actingAs($viewer)
        ->post(route('app.invoices.store'), [
            'purchase_order_id' => $po->id,
            'invoice_number'    => 'INV-001',
            'amount'            => 5000,
        ])
        ->assertForbidden();
});
