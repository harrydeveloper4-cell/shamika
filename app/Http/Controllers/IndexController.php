<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Property;
use App\Models\Booking; 
use App\Models\Inqury;
use App\Models\FAQs;

class IndexController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->take(4)->get();
        $avg = Testimonial::avg('rating');
        return view('index', compact('testimonials', 'avg'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        $faqs = FAQs::all();
        return view('contact', compact('faqs'));
    }

    public function properties()
    {
        $properties = Property::whereHas('inspections', function ($query) {
            $query->where('recommendation', 'approve');
        })->latest()->get();
        return view('properties', compact('properties'));
    }

    public function property(Property $property)
    {
        return view('property-detail', compact('property'));
    }

    public function applyViewing(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'preferred_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $property = Property::find($request->property_id);

        Booking::create([
            'renter_id' => auth()->id(),
            'property_id' => $request->property_id,
            'vendor_id' => $property->user_id,
            'booking_date' => $request->preferred_date,
            'notes' => $request->notes,
            'status' => 'pending' 
        ]);

        return back()->with('success', 'Viewing request submitted successfully! Vendor will review it soon[cite: 5].');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function submit_inquiry(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|string|email',
            'phone'   => 'required|string',
            'subject' => 'required|string',
            'message' => 'nullable|string', // Message optional kar diya hai
        ]);

        Inqury::create($validated);

        return redirect()->back()->with('success', 'Inquiry sent successfully.');
    }
}
