<?php

use App\Models\Organisation;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    $this->seed(\Database\Seeders\PlanSeeder::class);

    $this->org = Organisation::factory()->create();
    $this->user = User::factory()->create(['organisation_id' => $this->org->id]);
    $this->user->assignRole('procurement_manager');
});

it('can list vendors', function () {
    Vendor::factory()->count(3)->create(['organisation_id' => $this->org->id]);

    $this->actingAs($this->user)
        ->get(route('app.vendors.index'))
        ->assertOk()
        ->assertSee(Vendor::first()->name);
});

it('can create a vendor', function () {
    $this->actingAs($this->user)
        ->post(route('app.vendors.store'), [
            'name'  => 'Acme Supplies Ltd',
            'email' => 'acme@example.com',
            'phone' => '+260977000001',
        ])
        ->assertRedirect();

    expect(Vendor::where('name', 'Acme Supplies Ltd')->exists())->toBeTrue();
});

it('cannot see vendors from another organisation', function () {
    $otherOrg    = Organisation::factory()->create();
    $otherVendor = Vendor::factory()->create(['organisation_id' => $otherOrg->id]);

    $this->actingAs($this->user)
        ->get(route('app.vendors.show', $otherVendor))
        ->assertForbidden();
});
