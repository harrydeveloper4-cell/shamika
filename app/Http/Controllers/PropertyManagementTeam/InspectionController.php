<?php

namespace App\Http\Controllers\PropertyManagementTeam;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Services\InspectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InspectionController extends Controller
{
    protected $inspectionService;

    public function __construct(InspectionService $inspectionService)
    {
        $this->inspectionService = $inspectionService;
    }

    public function index()
    {
        Gate::authorize('view assigned inspections');
        $inspections = auth()->user()->inspections()->with('property')->latest()->get();
        return view('pm_team.inspections.index', compact('inspections'));
    }

    public function show(Inspection $inspection)
    {
        Gate::authorize('view assigned inspections', $inspection);
        return view('pm_team.inspections.show', compact('inspection'));
    }

    public function schedule(Inspection $inspection, Request $request)
    {
        Gate::authorize('schedule assigned inspection', $inspection);

        $request->validate([
            'scheduled_at' => 'required|date|after_or_equal:today',
        ]);

        $this->inspectionService->scheduleInspection($inspection, $request->scheduled_at);

        return back()->with('success', 'Inspection scheduled successfully.');
    }

    public function conduct(Inspection $inspection, Request $request)
    {
        Gate::authorize('conduct assigned inspection', $inspection);

        $request->validate([
            'notes' => 'required|string',
            // 'photos' => 'array', // Add validation for file uploads later
            // 'photos.*' => 'image|max:2048',
            // 'documents' => 'array',
            // 'documents.*' => 'file|max:5120',
        ]);

        $this->inspectionService->conductInspection($inspection, $request->notes);

        return back()->with('success', 'Inspection conducted successfully.');
    }

    public function submitReport(Inspection $inspection, Request $request)
    {
        Gate::authorize('submit inspection report', $inspection);

        $request->validate([
            'recommendation' => 'required|in:approve,reject',
        ]);

        $this->inspectionService->submitReport($inspection, $request->recommendation);

        return back()->with('success', 'Inspection report submitted successfully.');
    }
}
