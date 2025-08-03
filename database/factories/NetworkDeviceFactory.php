<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NetworkDevice>
 */
class NetworkDeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['ODC', 'ODP', 'closure', 'router', 'switch']);
        $portCount = match ($type) {
            'ODC' => fake()->numberBetween(16, 48),
            'ODP' => fake()->numberBetween(4, 16),
            'closure' => fake()->numberBetween(2, 8),
            'router' => fake()->numberBetween(4, 24),
            'switch' => fake()->numberBetween(8, 48),
            default => fake()->numberBetween(4, 24),
        };

        return [
            'name' => fake()->company() . ' ' . $type . '-' . fake()->numberBetween(1000, 9999),
            'type' => $type,
            'latitude' => fake()->latitude(-6.5, -6.0), // Jakarta area
            'longitude' => fake()->longitude(106.5, 107.0), // Jakarta area
            'address' => fake()->address(),
            'status' => fake()->randomElement(['active', 'inactive', 'maintenance']),
            'port_count' => $portCount,
            'ports_used' => fake()->numberBetween(0, $portCount),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the device is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the device is in maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'maintenance',
        ]);
    }
}