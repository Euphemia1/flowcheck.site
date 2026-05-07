<?php

use App\Models\Department;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    $this->seed(\Database\Seeders\PlanSeeder::class);

    $this->org = Organisation::factory()->create();
    $this->user = User::factory()->create(['organisation_id' => $this->org->id]);
    $this->user->assignRole('procurement_officer');

    $this->department = Department::factory()->create(['organisation_id' => $this->org->id]);
});

it('can view purchase requests index', function () {
    $this->actingAs($this->user)
        ->get(route('app.purchase-requests.index'))
        ->assertOk();
});

it('can create a purchase request', function () {
    $this->actingAs($this->user)
        ->post(route('app.purchase-requests.store'), [
            'title'          => 'Test PR',
            'department_id'  => $this->department->id,
            'priority'       => 'normal',
            'required_by_date' => now()->addDays(14)->toDateString(),
            'items' => [[
                'description'          => 'Office Supplies',
                'unit_of_measure'      => 'box',
                'quantity_requested'   => 5,
                'unit_price_estimated' => 100,
            ]],
        ])
        ->assertRedirect();

    expect(\App\Models\PurchaseRequest::count())->toBe(1);
});

it('scopes purchase requests to own organisation', function () {
    $otherOrg  = Organisation::factory()->create();
    $otherUser = User::factory()->create(['organisation_id' => $otherOrg->id]);
    $otherUser->assignRole('procurement_officer');

    $pr = \App\Models\PurchaseRequest::factory()->create([
        'organisation_id' => $otherOrg->id,
        'requested_by'    => $otherUser->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('app.purchase-requests.show', $pr))
        ->assertForbidden();
});

it('blocks users without create_purchase_requests permission', function () {
    $viewer = User::factory()->create(['organisation_id' => $this->org->id]);
    $viewer->assignRole('viewer');

    $this->actingAs($viewer)
        ->get(route('app.purchase-requests.create'))
        ->assertForbidden();
});
