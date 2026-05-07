<?php

use App\Models\Boq;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    $this->seed(\Database\Seeders\PlanSeeder::class);

    $this->org  = Organisation::factory()->create();
    $this->user = User::factory()->create(['organisation_id' => $this->org->id]);
    $this->user->assignRole('procurement_manager');
});

it('can create a BOQ', function () {
    $this->actingAs($this->user)
        ->post(route('app.boqs.store'), [
            'project_name'       => 'Site Preparation',
            'project_location'   => 'Lusaka',
            'procurement_method' => 'open_tender',
            'items' => [[
                'description' => 'Excavation',
                'category'    => 'Earthworks',
                'unit'        => 'm3',
                'quantity'    => 100,
                'unit_rate'   => 250,
            ]],
        ])
        ->assertRedirect();

    expect(Boq::count())->toBe(1);
});

it('scopes BOQ to organisation', function () {
    $otherOrg  = Organisation::factory()->create();
    $otherUser = User::factory()->create(['organisation_id' => $otherOrg->id]);
    $otherUser->assignRole('procurement_manager');

    $boq = Boq::factory()->create(['organisation_id' => $otherOrg->id]);

    $this->actingAs($this->user)
        ->get(route('app.boqs.show', $boq))
        ->assertForbidden();
});

it('generates BOQ PDF', function () {
    $boq = Boq::factory()->create([
        'organisation_id'    => $this->org->id,
        'procurement_method' => 'rfq',
        'items'              => [['description' => 'Concrete', 'category' => 'Concrete Works', 'unit' => 'm3', 'quantity' => 50, 'unit_rate' => 800]],
    ]);

    $this->actingAs($this->user)
        ->get(route('app.boqs.pdf', $boq))
        ->assertOk()
        ->assertHeader('content-type', 'application/pdf');
});
