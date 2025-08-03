<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\BillingRecord;
use Illuminate\Support\Facades\Log;

class MikroTikService
{
    /**
     * Sync customer usage data from MikroTik API
     *
     * @param Customer $customer
     * @return array|null
     */
    public function syncCustomerUsage(Customer $customer): ?array
    {
        if (!$customer->mikrotik_username) {
            return null;
        }

        try {
            // Mock MikroTik API response - in production, replace with actual API calls
            $usageData = $this->getMockUsageData($customer->mikrotik_username);
            
            // Update customer's last sync timestamp
            $customer->update(['last_usage_sync' => now()]);
            
            return $usageData;
        } catch (\Exception $e) {
            Log::error('MikroTik sync failed for customer: ' . $customer->id, [
                'error' => $e->getMessage(),
                'customer_id' => $customer->id,
                'mikrotik_username' => $customer->mikrotik_username,
            ]);
            
            return null;
        }
    }

    /**
     * Bulk sync all customers with MikroTik usernames
     *
     * @return array
     */
    public function syncAllCustomers(): array
    {
        $customers = Customer::whereNotNull('mikrotik_username')->get();
        $results = [
            'success' => 0,
            'failed' => 0,
            'total' => $customers->count(),
        ];

        foreach ($customers as $customer) {
            $usageData = $this->syncCustomerUsage($customer);
            
            if ($usageData) {
                $results['success']++;
                
                // Create or update billing record for current month
                $this->updateBillingRecord($customer, $usageData);
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }

    /**
     * Update or create billing record based on usage data
     *
     * @param Customer $customer
     * @param array $usageData
     * @return BillingRecord
     */
    protected function updateBillingRecord(Customer $customer, array $usageData): BillingRecord
    {
        $currentMonth = now()->format('Y-m');
        
        return BillingRecord::updateOrCreate(
            [
                'customer_id' => $customer->id,
                'period_month' => $currentMonth,
            ],
            [
                'usage_mb' => $usageData['total_bytes'] / (1024 * 1024), // Convert to MB
                'mikrotik_data' => $usageData,
                'amount' => $this->calculateBillingAmount($customer, $usageData),
                'due_date' => now()->addDays(30),
            ]
        );
    }

    /**
     * Calculate billing amount based on usage and customer package
     *
     * @param Customer $customer
     * @param array $usageData
     * @return float
     */
    protected function calculateBillingAmount(Customer $customer, array $usageData): float
    {
        // Base pricing logic - customize based on your billing model
        $packageRates = [
            'Basic 10Mbps' => 150000,
            'Standard 25Mbps' => 250000,
            'Premium 50Mbps' => 400000,
            'Enterprise 100Mbps' => 750000,
        ];

        $baseAmount = $packageRates[$customer->package] ?? 200000;
        
        // Add overage charges if usage exceeds package limits
        $usageGB = $usageData['total_bytes'] / (1024 * 1024 * 1024);
        $packageLimits = [
            'Basic 10Mbps' => 100,
            'Standard 25Mbps' => 250,
            'Premium 50Mbps' => 500,
            'Enterprise 100Mbps' => 1000,
        ];
        
        $limit = $packageLimits[$customer->package] ?? 200;
        
        if ($usageGB > $limit) {
            $overage = $usageGB - $limit;
            $overageRate = 2000; // IDR per GB
            $baseAmount += $overage * $overageRate;
        }

        return $baseAmount;
    }

    /**
     * Mock MikroTik API response for development
     *
     * @param string $username
     * @return array
     */
    protected function getMockUsageData(string $username): array
    {
        return [
            'username' => $username,
            'total_bytes' => random_int(10737418240, 53687091200), // 10GB to 50GB
            'download_bytes' => random_int(8589934592, 42949672960), // 8GB to 40GB
            'upload_bytes' => random_int(1073741824, 5368709120), // 1GB to 5GB
            'session_time' => random_int(86400, 2592000), // 1 day to 30 days in seconds
            'last_seen' => now()->subHours(random_int(1, 48))->toISOString(),
            'ip_address' => '192.168.1.' . random_int(10, 254),
            'mac_address' => $this->generateMacAddress(),
            'connection_time' => random_int(3600, 86400), // 1 hour to 24 hours
            'status' => 'active',
        ];
    }

    /**
     * Generate a random MAC address for mock data
     *
     * @return string
     */
    protected function generateMacAddress(): string
    {
        $mac = [];
        for ($i = 0; $i < 6; $i++) {
            $mac[] = str_pad(dechex(random_int(0, 255)), 2, '0', STR_PAD_LEFT);
        }
        return implode(':', $mac);
    }

    /**
     * Manage customer account on MikroTik (enable/disable/suspend)
     *
     * @param Customer $customer
     * @param string $action
     * @return bool
     */
    public function manageCustomerAccount(Customer $customer, string $action): bool
    {
        if (!$customer->mikrotik_username) {
            return false;
        }

        try {
            // Mock API call - in production, implement actual MikroTik API integration
            Log::info("MikroTik account {$action} for customer: {$customer->id}", [
                'customer_id' => $customer->id,
                'mikrotik_username' => $customer->mikrotik_username,
                'action' => $action,
            ]);

            // Update customer status based on action
            switch ($action) {
                case 'enable':
                    $customer->update(['status' => 'active']);
                    break;
                case 'disable':
                    $customer->update(['status' => 'inactive']);
                    break;
                case 'suspend':
                    $customer->update(['status' => 'suspended']);
                    break;
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to {$action} MikroTik account for customer: {$customer->id}", [
                'error' => $e->getMessage(),
                'customer_id' => $customer->id,
                'mikrotik_username' => $customer->mikrotik_username,
            ]);

            return false;
        }
    }
}