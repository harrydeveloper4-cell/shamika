<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PayoutController extends Controller
{
    public function index()
    {
        Gate::authorize('manage vendor payouts');
        $payouts = Payout::with('booking')->latest()->get();
        return view('admin.payouts.index', compact('payouts'));
    }

    public function create()
    {
        Gate::authorize('manage vendor payouts');
        $vendors = User::role('vendor')->get();
        return view('admin.payouts.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        Gate::authorize('manage vendor payouts');

        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payout_date' => 'required|date',
            'status' => 'required|in:pending,processing,completed,failed',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $vendor = User::findOrFail($request->vendor_id);
        if (!$vendor->hasRole('vendor')) {
            return back()->withErrors(['vendor_id' => 'The selected user is not a vendor.']);
        }

        Payout::create($request->all());

        return redirect()->route('admin.payouts.index')->with('success', 'Payout created successfully.');
    }

    public function show(Payout $payout)
    {
        Gate::authorize('manage vendor payouts');
        $payout->load('vendor');
        return view('admin.payouts.show', compact('payout'));
    }

    public function edit(Payout $payout)
    {
        Gate::authorize('manage vendor payouts');
        $payout->load('vendor');
        $vendors = User::role('vendor')->get();
        return view('admin.payouts.edit', compact('payout', 'vendors'));
    }

    public function update(Request $request, Payout $payout)
    {
        Gate::authorize('manage vendor payouts');

        $request->validate([
            'transaction_id' => 'required|string|max:255',
            'payout_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $payout->update([
            'transaction_id' => $request->transaction_id,
            'payout_date' => $request->payout_date,
            'notes' => $request->notes,
            'status' => 'completed', // Ya jo bhi status aap rakhna chahein (jaise completed ya approved)
        ]);

        return redirect()->route('admin.payouts.index')->with('success', 'Payout updated successfully.');
    }

    public function destroy(Payout $payout)
    {
        Gate::authorize('manage vendor payouts');
        $payout->delete();
        return redirect()->route('admin.payouts.index')->with('success', 'Payout deleted successfully.');
    }
}
