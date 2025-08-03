<?php

use App\Models\Region;
use App\Models\User;

it('allows authenticated user to view regions index', function () {
    $user = User::factory()->create();
    Region::factory(4)->create();

    $response = $this->actingAs($user)->get('/regions');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('regions/index')
        ->has('regions.data', 4)
    );
});

it('allows authenticated user to create region', function () {
    $user = User::factory()->create();

    $regionData = [
        'name' => 'Jakarta North',
        'code' => 'JKT-N-001',
        'description' => 'North Jakarta development region',
        'stage' => 'data',
        'boundaries' => [
            'coordinates' => [
                [-6.1, 106.8],
                [-6.1, 106.9],
                [-6.2, 106.9],
                [-6.2, 106.8],
            ]
        ],
    ];

    $response = $this->actingAs($user)->post('/regions', $regionData);

    $response->assertRedirect();
    $this->assertDatabaseHas('regions', [
        'name' => 'Jakarta North',
        'code' => 'JKT-N-001',
        'stage' => 'data',
    ]);
});

it('requires unique region code', function () {
    $user = User::factory()->create();
    Region::factory()->create(['code' => 'JKT-001']);

    $regionData = [
        'name' => 'Test Region',
        'code' => 'JKT-001', // Duplicate code
        'stage' => 'data',
    ];

    $response = $this->actingAs($user)->post('/regions', $regionData);

    $response->assertSessionHasErrors('code');
});

it('enforces region stage progression', function () {
    $user = User::factory()->create();
    $region = Region::factory()->create(['stage' => 'data']);

    // Should not be able to jump from 'data' to 'rab' (skipping 'design')
    $response = $this->actingAs($user)->patch("/regions/{$region->id}", [
        'stage' => 'rab',
    ]);

    $response->assertSessionHasErrors('stage');
});

it('prevents guest access to regions', function () {
    $response = $this->get('/regions');

    $response->assertRedirect('/login');
});