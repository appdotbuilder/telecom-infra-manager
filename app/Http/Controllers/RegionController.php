<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegionRequest;
use App\Models\Region;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::latest()->paginate(15);
        
        return Inertia::render('regions/index', [
            'regions' => $regions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('regions/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegionRequest $request)
    {
        $data = $request->validated();
        
        // Set stage completion based on the stage
        $stage = $data['stage'];
        $data['data_completed'] = in_array($stage, ['data', 'design', 'rab', 'permits', 'completed']);
        $data['design_completed'] = in_array($stage, ['design', 'rab', 'permits', 'completed']);
        $data['rab_completed'] = in_array($stage, ['rab', 'permits', 'completed']);
        $data['permits_completed'] = in_array($stage, ['permits', 'completed']);
        
        $region = Region::create($data);

        return redirect()->route('regions.show', $region)
            ->with('success', 'Region created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        return Inertia::render('regions/show', [
            'region' => $region
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        return Inertia::render('regions/edit', [
            'region' => $region
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Region $region)
    {
        $stage = $request->input('stage', $region->stage);
        
        // Validate stage progression
        $stageOrder = ['data', 'design', 'rab', 'permits', 'completed'];
        $currentStageIndex = array_search($region->stage, $stageOrder);
        $newStageIndex = array_search($stage, $stageOrder);
        
        if ($newStageIndex > $currentStageIndex + 1) {
            return back()->withErrors(['stage' => 'You must complete stages sequentially.']);
        }
        
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'boundaries' => 'nullable|array',
            'design_data' => 'nullable|array',
            'rab_data' => 'nullable|array',
            'permits_data' => 'nullable|array',
            'stage' => 'sometimes|in:data,design,rab,permits,completed',
        ]);
        
        // Update stage completion flags
        if (isset($data['stage'])) {
            $data['data_completed'] = in_array($data['stage'], ['data', 'design', 'rab', 'permits', 'completed']);
            $data['design_completed'] = in_array($data['stage'], ['design', 'rab', 'permits', 'completed']);
            $data['rab_completed'] = in_array($data['stage'], ['rab', 'permits', 'completed']);
            $data['permits_completed'] = in_array($data['stage'], ['permits', 'completed']);
        }
        
        $region->update($data);

        return redirect()->route('regions.show', $region)
            ->with('success', 'Region updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return redirect()->route('regions.index')
            ->with('success', 'Region deleted successfully.');
    }
}