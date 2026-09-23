<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Property;
use App\Models\Config;
use App\Services\VerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VerificationController extends Controller
{
    protected $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;

        $configs = Config::latest()->get();
        $config = [];
        foreach($configs as $val) {
            $config[$val->key] = $val->value;
        }
        return view()->share('config', $config);    
    }

    public function index()
    {
        Gate::authorize('review inspection reports');
        $inspections = Inspection::with(['property.user', 'inspector'])
            ->where('status', 'Report Submitted')
            ->latest()->get();

        return view('admin.verifications.index', compact('inspections'));
    }

    public function show(Inspection $inspection)
    {
        Gate::authorize('review inspection reports');
        $inspection->load(['property.user', 'inspector']);
        return view('admin.verifications.show', compact('inspection'));
    }

    public function decide(Property $property, Request $request)
    {
        Gate::authorize('make verification decisions');

        $request->validate([
            'decision' => 'required|in:Verified,Rejected',
            'reason' => 'nullable|string',
            'inspection_id' => 'nullable|exists:inspections,id',
        ]);

        $inspection = null;
        if ($request->has('inspection_id')) {
            $inspection = Inspection::find($request->inspection_id);
        }

        $this->verificationService->makeVerificationDecision(
            $property,
            auth()->user(),
            $request->decision,
            $request->reason,
            $inspection
        );

        // Additional logic for 'Verified Company Badge' issuance can be integrated here.
        // The `is_verified` field on the Property model is already updated by the service.

        return back()->with('success', 'Verification decision made successfully.');
    }
}
