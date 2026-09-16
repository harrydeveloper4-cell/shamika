<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommissionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('manage commissions');
        $commissionSettings = CommissionSetting::latest()->get();
        return view('admin.commission_settings.index', compact('commissionSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('manage commissions');
        return view('admin.commission_settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage commissions');
        $request->validate([
            'name' => 'required|string|max:255|unique:commission_settings,name',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        CommissionSetting::create($request->all());

        return redirect()->route('admin.commission-settings.index')->with('success', 'Commission Setting created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CommissionSetting $commissionSetting)
    {
        Gate::authorize('manage commissions');
        return view('admin.commission_settings.show', compact('commissionSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommissionSetting $commissionSetting)
    {
        Gate::authorize('manage commissions');
        return view('admin.commission_settings.edit', compact('commissionSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommissionSetting $commissionSetting)
    {
        Gate::authorize('manage commissions');
        $request->validate([
            'name' => 'required|string|max:255|unique:commission_settings,name,' . $commissionSetting->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $commissionSetting->update($request->all());

        return redirect()->route('admin.commission-settings.index')->with('success', 'Commission Setting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommissionSetting $commissionSetting)
    {
        Gate::authorize('manage commissions');
        $commissionSetting->delete();

        return redirect()->route('admin.commission-settings.index')->with('success', 'Commission Setting deleted successfully.');
    }
}
