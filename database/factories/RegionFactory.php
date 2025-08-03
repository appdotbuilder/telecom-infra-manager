<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stage = fake()->randomElement(['data', 'design', 'rab', 'permits', 'completed']);
        
        return [
            'name' => fake()->city() . ' ' . fake()->randomElement(['North', 'South', 'East', 'West', 'Central']),
            'code' => fake()->unique()->bothify('REG-###-??'),
            'description' => fake()->paragraph(),
            'boundaries' => [
                'coordinates' => [
                    [fake()->latitude(-6.5, -6.0), fake()->longitude(106.5, 107.0)],
                    [fake()->latitude(-6.5, -6.0), fake()->longitude(106.5, 107.0)],
                    [fake()->latitude(-6.5, -6.0), fake()->longitude(106.5, 107.0)],
                    [fake()->latitude(-6.5, -6.0), fake()->longitude(106.5, 107.0)],
                ]
            ],
            'design_data' => in_array($stage, ['design', 'rab', 'permits', 'completed']) ? [
                'plan_file' => 'designs/region-plan-' . fake()->numberBetween(1000, 9999) . '.pdf',
                'technical_specs' => fake()->paragraph(),
                'estimated_coverage' => fake()->numberBetween(500, 5000) . ' households',
            ] : null,
            'rab_data' => in_array($stage, ['rab', 'permits', 'completed']) ? [
                'budget_estimate' => fake()->numberBetween(500000000, 2000000000), // in IDR
                'cost_breakdown' => [
                    'infrastructure' => fake()->numberBetween(300000000, 1200000000),
                    'equipment' => fake()->numberBetween(100000000, 400000000),
                    'labor' => fake()->numberBetween(50000000, 200000000),
                    'permits' => fake()->numberBetween(25000000, 100000000),
                ]
            ] : null,
            'permits_data' => in_array($stage, ['permits', 'completed']) ? [
                'permits_required' => ['IMB', 'Izin Lingkungan', 'Izin Telekomunikasi'],
                'applications_submitted' => fake()->dateTimeThisYear()->format('Y-m-d'),
                'approval_status' => fake()->randomElement(['pending', 'approved', 'revision_required']),
            ] : null,
            'stage' => $stage,
            'data_completed' => in_array($stage, ['data', 'design', 'rab', 'permits', 'completed']),
            'design_completed' => in_array($stage, ['design', 'rab', 'permits', 'completed']),
            'rab_completed' => in_array($stage, ['rab', 'permits', 'completed']),
            'permits_completed' => in_array($stage, ['permits', 'completed']),
        ];
    }

    /**
     * Indicate that the region is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'stage' => 'completed',
            'data_completed' => true,
            'design_completed' => true,
            'rab_completed' => true,
            'permits_completed' => true,
        ]);
    }
}