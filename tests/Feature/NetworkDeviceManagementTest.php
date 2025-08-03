<?php

use App\Models\NetworkDevice;
use App\Models\User;

it('allows authenticated user to view network devices index', function () {
    $user = User::factory()->create();
    NetworkDevice::factory(3)->create();

    $response = $this->actingAs($user)->get('/network-devices');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('network-devices/index')
        ->has('devices.data', 3)
    );
});

it('allows authenticated user to create network device', function () {
    $user = User::factory()->create();

    $deviceData = [
        'name' => 'ODC Jakarta-001',
        'type' => 'ODC',
        'latitude' => -6.2088,
        'longitude' => 106.8456,
        'address' => 'Jakarta, Indonesia',
        'status' => 'active',
        'port_count' => 24,
        'ports_used' => 12,
        'notes' => 'Main ODC for Jakarta area',
    ];

    $response = $this->actingAs($user)->post('/network-devices', $deviceData);

    $response->assertRedirect();
    $this->assertDatabaseHas('network_devices', [
        'name' => 'ODC Jakarta-001',
        'type' => 'ODC',
    ]);
});

it('validates device coordinates', function () {
    $user = User::factory()->create();

    $deviceData = [
        'name' => 'Test Device',
        'type' => 'ODC',
        'latitude' => 91, // Invalid - must be between -90 and 90
        'longitude' => 181, // Invalid - must be between -180 and 180
        'status' => 'active',
    ];

    $response = $this->actingAs($user)->post('/network-devices', $deviceData);

    $response->assertSessionHasErrors(['latitude', 'longitude']);
});

it('prevents guest access to network devices', function () {
    $response = $this->get('/network-devices');

    $response->assertRedirect('/login');
});