<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PropertySearchController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('search properties');

        $query = Property::where('verification_status', 'Verified')
            ->whereNotNull('published_at');

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
}
