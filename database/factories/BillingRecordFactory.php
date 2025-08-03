<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillingRecord>
 */
class BillingRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 150000, 500000); // IDR
        $usageMb = fake()->randomFloat(2, 1000, 50000); // GB usage
        
        return [
            'customer_id' => Customer::factory(),
            'amount' => $amount,
            'period_month' => fake()->dateTimeThisYear()->format('Y-m'),
            'usage_mb' => $usageMb,
            'status' => fake()->randomElement(['pending', 'paid', 'overdue']),
            'due_date' => fake()->dateTimeBetween('now', '+30 days'),
            'paid_at' => fake()->optional(0.7)->dateTimeThisMonth(),
            'mikrotik_data' => [
                'download_bytes' => fake()->numberBetween(1073741824, 53687091200), // 1GB to 50GB in bytes
                'upload_bytes' => fake()->numberBetween(107374182, 5368709120), // 100MB to 5GB in bytes
                'session_time' => fake()->numberBetween(86400, 2592000), // 1 day to 30 days in seconds
                'last_sync' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * Indicate that the billing record is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_at' => fake()->dateTimeThisMonth(),
        ]);
    }

    /**
     * Indicate that the billing record is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'due_date' => fake()->dateTimeBetween('-30 days', '-1 day'),
            'paid_at' => null,
        ]);
    }
}