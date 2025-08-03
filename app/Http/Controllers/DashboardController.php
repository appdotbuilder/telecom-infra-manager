<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\NetworkDevice;
use App\Models\Region;
use App\Models\BillingRecord;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $stats = [
            'customers' => Customer::count(),
            'active_customers' => Customer::where('status', 'active')->count(),
            'network_devices' => NetworkDevice::count(),
            'active_devices' => NetworkDevice::where('status', 'active')->count(),
            'regions' => Region::count(),
            'completed_regions' => Region::where('stage', 'completed')->count(),
            'pending_bills' => BillingRecord::where('status', 'pending')->count(),
            'overdue_bills' => BillingRecord::where('status', 'overdue')->count(),
        ];

        $recent_customers = Customer::latest()->take(5)->get();
        $recent_devices = NetworkDevice::latest()->take(5)->get();
        $recent_regions = Region::latest()->take(5)->get();

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'recent_customers' => $recent_customers,
            'recent_devices' => $recent_devices,
            'recent_regions' => $recent_regions,
        ]);
    }
}