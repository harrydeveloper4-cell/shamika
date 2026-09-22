<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonitoringRequest;
use App\Models\User;
use App\Models\Config;
use App\Services\InspectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MonitoringRequestController extends Controller
{
    protected $inspectionService;

    public function __construct(InspectionService $inspectionService)
    {
        $this->inspectionService = $inspectionService;
    }

    public function index()
    {
        Gate::authorize('view monitoring requests');
        $monitoringRequests = MonitoringRequest::with(['property', 'vendor', 'admin', 'assignedInspector', 'renter'])->latest()->get();
        return view('admin.monitoring_requests.index', compact('monitoringRequests'));
    }

    public function show(MonitoringRequest $monitoringRequest)
    {
        Gate::authorize('view monitoring requests');
        $monitoringRequest->load(['property', 'vendor', 'admin', 'assignedInspector', 'renter']);
        $propertyManagementTeamMembers = User::role('property_management_team')->get();
        return view('admin.monitoring_requests.show', compact('monitoringRequest', 'propertyManagementTeamMembers'));
    }

    public function review(MonitoringRequest $monitoringRequest, Request $request)
    {
        Gate::authorize('review monitoring requests'); // Assuming a permission for reviewing monitoring requests

        $request->validate([
            'status' => 'required|in:pending,reviewed,assigned,rejected',
            'notes' => 'nullable|string',
        ]);

        $monitoringRequest->update([
            'status' => $request->status,
            'admin_id' => auth()->id(),
            'notes' => $request->notes,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Monitoring request reviewed successfully.');
    }

    public function assignInspector(MonitoringRequest $monitoringRequest, Request $request)
    {
        Gate::authorize('assign inspections');

        $request->validate([
            'inspector_id' => 'required|exists:users,id',
        ]);

        // Ensure the assigned user is a property management team member
        $inspector = User::findOrFail($request->inspector_id);
        if (!$inspector->hasRole('property_management_team')) {
            return back()->withErrors(['inspector_id' => 'The selected user is not a Property Management Team member.']);
        }

        if ($monitoringRequest->status !== 'reviewed') {
            return back()->withErrors(['status' => 'Only reviewed monitoring requests can be assigned an inspector.']);
        }

        $this->inspectionService->assignInspection($monitoringRequest->property, $inspector, $monitoringRequest);

        $monitoringRequest->update([
            'assigned_inspector_id' => $inspector->id,
            'assigned_at' => now(),
            'status' => 'assigned',
        ]);

        return back()->with('success', 'Inspector assigned successfully.');
    }
}
