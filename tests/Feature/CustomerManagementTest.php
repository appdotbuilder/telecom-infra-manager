<?php

use App\Models\Customer;
use App\Models\User;

it('allows authenticated user to view customers index', function () {
    $user = User::factory()->create();
    Customer::factory(5)->create();

    $response = $this->actingAs($user)->get('/customers');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('customers/index')
        ->has('customers.data', 5)
    );
});

it('allows authenticated user to create customer', function () {
    $user = User::factory()->create();

    $customerData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'address' => '123 Main St',
        'status' => 'active',
        'mikrotik_username' => 'johndoe',
        'package' => 'Standard 25Mbps',
    ];

    $response = $this->actingAs($user)->post('/customers', $customerData);

    $response->assertRedirect();
    $this->assertDatabaseHas('customers', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('requires unique customer email', function () {
    $user = User::factory()->create();
    Customer::factory()->create(['email' => 'existing@example.com']);

    $customerData = [
        'name' => 'John Doe',
        'email' => 'existing@example.com',
        'status' => 'active',
    ];

    $response = $this->actingAs($user)->post('/customers', $customerData);

    $response->assertSessionHasErrors('email');
});

it('prevents guest access to customers', function () {
    $response = $this->get('/customers');

    $response->assertRedirect('/login');
});