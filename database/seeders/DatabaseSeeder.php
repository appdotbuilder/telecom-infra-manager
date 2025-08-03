<?php

namespace Database\Seeders;

use App\Models\BillingRecord;
use App\Models\Customer;
use App\Models\NetworkDevice;
use App\Models\Region;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@telecom.com',
        ]);

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create customers with billing records
        Customer::factory(50)
            ->has(BillingRecord::factory(3), 'billingRecords')
            ->create();

        // Create network devices
        NetworkDevice::factory(30)->create();

        // Create regions in different stages
        Region::factory(5)->create(['stage' => 'data']);
        Region::factory(4)->create(['stage' => 'design']);
        Region::factory(3)->create(['stage' => 'rab']);
        Region::factory(2)->create(['stage' => 'permits']);
        Region::factory(6)->completed()->create();
    }
}
