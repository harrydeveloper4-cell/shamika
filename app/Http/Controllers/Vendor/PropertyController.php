<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\MonitoringRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('admin')){
            $properties = Property::with('images')->latest()->get();
            return view('admin.properties.index', compact('properties'));
        } else {
            Gate::authorize('view own properties');
            $properties = auth()->user()->properties()->with(['images', 'monitoringRequests' => function($query) {
                $query->with('renter');
            }])->latest()->get();
            return view('vendor.properties.index', compact('properties'));
        }
    }

    public function show(Property $property)
    {
        $property->load('images');
        if(auth()->user()->hasRole('admin')){
            return view('admin.properties.show', compact('property'));
        }else{
            // Gate::authorize('view own property', $property);
            return view('vendor.properties.show', compact('property'));
        }
    }

    public function create()
    {
        if(auth()->user()->hasRole('admin')){
            $properties = Property::all();
            $users = User::whereHas('roles', function ($q) { $q->whereIn('name', ['vendor', 'admin']); })->orderBy('name')->get();
            return view('admin.properties.create', compact('properties', 'users'));
        } else {
            Gate::authorize('create property');
            return view('vendor.properties.create');
        }
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            $rules = [
                'user_id' => 'required|exists:users,id',
            ];
        } else {
            Gate::authorize('create property');
            $rules = [];
        }

        $validatedData = $request->validate(array_merge($rules, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gallery_images' => 'nullable|array|max:20',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'type' => 'required|string|max:255',
            'purpose' => 'required|string|in:sell,rent',
        ]));

        if ($request->hasFile('main_image')) {
            $imageName = time() . '_' . $request->file('main_image')->getClientOriginalName();
            $request->file('main_image')->move(public_path('properties/main'), $imageName);
            $validatedData['main_image'] = 'properties/main/' . $imageName;
        }

        $propertyData = auth()->user()->hasRole('admin')
            ? array_merge($validatedData, ['owner_type' => 'admin'])
            : array_merge($validatedData, ['owner_type' => 'vendor']);

        if (auth()->user()->hasRole('admin')) {
            $property = Property::create($propertyData);
        } else {
            $property = auth()->user()->properties()->create($propertyData);
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('properties/gallery'), $imageName);
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => 'properties/gallery/' . $imageName,
                    'sort_order' => $index,
                ]);
            }
        }

        if(auth()->user()->hasRole('admin')){

            MonitoringRequest::create([
                'property_id' => $property->id,
                'vendor_id' => auth()->id(),
                'status' => 'Pending',
            ]);
            $property->update([
                'verification_status' => 'Under Review',
            ]);

            return redirect()->route('admin.properties.index')->with('success', 'Property created successfully.');
        }else{
            return redirect()->route('vendor.properties.index')->with('success', 'Property created successfully.');
        }
    }

    public function edit(Property $property)
    {
        Gate::authorize('edit own property', $property);
        $property->load('images');
        return view('vendor.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        Gate::authorize('edit own property', $property);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_main_image' => 'nullable|boolean',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'exists:property_images,id',
            'gallery_images' => 'nullable|array|max:20',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'type' => 'required|string|max:255',
            'purpose' => 'required|string|in:sell,rent',
        ]);

        if ($request->hasFile('main_image')) {
            if ($property->main_image) {
                Storage::disk('public')->delete($property->main_image);
            }
            $imageName = time() . '_' . $request->file('main_image')->getClientOriginalName();
            $request->file('main_image')->move(public_path('properties/main'), $imageName);
            $validatedData['main_image'] = 'properties/main/' . $imageName;
        } elseif ($request->boolean('remove_main_image')) {
            if ($property->main_image) {
                Storage::disk('public')->delete($property->main_image);
            }
            $validatedData['main_image'] = null;
        }

        if ($request->filled('remove_images')) {
            foreach ($request->input('remove_images') as $imgId) {
                $img = PropertyImage::find($imgId);
                if ($img && $img->property_id === $property->id) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('gallery_images')) {
            $currentMax = PropertyImage::where('property_id', $property->id)->max('sort_order') ?? -1;
            foreach ($request->file('gallery_images') as $i => $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('properties/gallery'), $imageName);
                $validatedData['gallery_images'][] = 'properties/gallery/' . $imageName;
            }
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $i => $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('properties/gallery'), $imageName);
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => 'properties/gallery/' . $imageName,
                    'sort_order' => $currentMax + 1 + $i,
                ]);
            }
        }

        $property->update($validatedData);

        return redirect()->route('vendor.properties.index')->with('success', 'Property updated successfully.');
    }

    public function archive(Property $property)
    {
        Gate::authorize('archive own property', $property);
        $property->update(['archived_at' => now()]);
        return back()->with('success', 'Property archived successfully.');
    }

    public function submitMonitoringRequest(Property $property)
    {
        Gate::authorize('submit monitoring request', $property);

        if ($property->user_id !== auth()->id()) {
            abort(403, 'You do not own this property.');
        }

        if (MonitoringRequest::where('property_id', $property->id)->where('status', 'Pending')->exists()) {
            return back()->with('info', 'A pending monitoring request already exists for this property.');
        }

        MonitoringRequest::create([
            'property_id' => $property->id,
            'vendor_id' => auth()->id(),
            'status' => 'Pending',
        ]);
        $property->update([
            'verification_status' => 'Under Review',
        ]);

        return back()->with('success', 'Monitoring request submitted successfully.');
    }

    public function bookingRequest()
    {
        $bookings = Booking::where('vendor_id', auth()->id())->with('property')->with('renter')->get();
        if(auth()->user()->hasRole('admin')){
            return view('admin.properties.booking-request', compact('bookings'));
        } else {
            return view('vendor.properties.booking-request', compact('bookings'));
        }
    }
}

