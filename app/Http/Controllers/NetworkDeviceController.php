<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNetworkDeviceRequest;
use App\Models\NetworkDevice;
use Inertia\Inertia;

class NetworkDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = NetworkDevice::latest()->paginate(15);
        
        return Inertia::render('network-devices/index', [
            'devices' => $devices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('network-devices/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNetworkDeviceRequest $request)
    {
        $device = NetworkDevice::create($request->validated());

        return redirect()->route('network-devices.show', $device)
            ->with('success', 'Network device created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NetworkDevice $networkDevice)
    {
        return Inertia::render('network-devices/show', [
            'device' => $networkDevice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NetworkDevice $networkDevice)
    {
        return Inertia::render('network-devices/edit', [
            'device' => $networkDevice
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreNetworkDeviceRequest $request, NetworkDevice $networkDevice)
    {
        $networkDevice->update($request->validated());

        return redirect()->route('network-devices.show', $networkDevice)
            ->with('success', 'Network device updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NetworkDevice $networkDevice)
    {
        $networkDevice->delete();

        return redirect()->route('network-devices.index')
            ->with('success', 'Network device deleted successfully.');
    }
}