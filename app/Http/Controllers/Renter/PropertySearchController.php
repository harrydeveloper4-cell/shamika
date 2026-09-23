<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\MonitoringRequest;

class PropertySearchController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('search properties');

        $userId = auth()->id();

        $query = Property::where('verification_status', 'Verified')
            ->with('bookings')
            ->where(function($q) use ($userId) {
                $q->where('user_id', $userId) // Agar property ka vendor khud logged-in user hai
                ->orWhereHas('bookings', function($subQuery) use ($userId) {
                    $subQuery->where('renter_id', $userId);
                            // ->orWhere('vendor_id', $userId);
                });
            });
        // $query = Property::where('verification_status', 'Verified')->with('bookings')
            // ->whereNotNull('published_at');

        // Apply filters
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('address', 'like', '%' . $request->location . '%')
                    ->orWhere('city', 'like', '%' . $request->location . '%')
                    ->orWhere('state', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        $properties = $query->latest()->get();

        return view('renter.properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        Gate::authorize('view property details');

        if ($property->verification_status !== 'Verified' || $property->published_at === null) {
            abort(404);
        }

        return view('renter.properties.show', compact('property'));
    }

    public function requestViewing(Request $request, Property $property)
    {
        Gate::authorize('request property viewing');

        if ($property->user_id === auth()->id()) {
            return back()->withErrors(['message' => 'You cannot request a viewing for your own property.']);
        }

        $existingRequest = MonitoringRequest::where('property_id', $property->id)
            ->where('renter_id', auth()->id())
            ->whereIn('status', ['pending', 'reviewed', 'assigned'])
            ->first();

        if ($existingRequest) {
            return back()->with('info', 'You have already submitted a viewing request for this property.');
        }

        MonitoringRequest::create([
            'property_id' => $property->id,
            'renter_id' => auth()->id(),
            'vendor_id' => $property->user_id, // The vendor is the owner of the property
            'status' => 'pending',
            'notes' => 'Renter requested a property viewing.',
        ]);

        return back()->with('success', 'Property viewing request submitted successfully. The property owner will be notified.');
    }

    public function bookingRequest()
    {
        $userId = auth()->id();
        $bookings = Booking::where('renter_id', $userId)->with(['property', 'vendor'])->get();
        return view('renter.properties.booking-request', compact('bookings'));
    }
}

