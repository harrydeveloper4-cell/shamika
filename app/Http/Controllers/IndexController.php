<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\Testimonial;
use App\Models\Property;
use App\Models\Booking; 
use App\Models\Inqury;
use App\Models\FAQs;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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
        $properties = Property::whereNotIn('verification_status', ['Rejected', 'Sold'])->whereHas('inspections', function ($query) {
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
    
    public function acceptToPay(Booking $booking): RedirectResponse
    {
        $booking->update([
            'status' => 'confirmed',
        ]);

        if(auth()->user()->hasRole('admin')){
            return Redirect::route('admin.booking.request')->with('status', 'booking-request-accepted');
        }else{
            return Redirect::route('vendor.booking.request')->with('status', 'booking-request-accepted');
        }

    }

    public function paynow($encryptedId)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $bookingId = decrypt($encryptedId);
        $booking = Booking::find($bookingId);

        $property = $booking->property;
        $unitAmount = $property->price * 100; 

        $checkoutSession = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd', 
                    'product_data' => [
                        'name' => $property->title,
                        'description' => 'Booking for ' . $property->title,
                    ],
                    'unit_amount' => $unitAmount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', $encryptedId), // Will create this route
            'cancel_url' => route('checkout.cancel', $encryptedId),   // Will create this route
            'metadata' => [
                'booking_id' => $booking->id,
                'renter_id' => $booking->renter_id,
            ],
        ]);

        return Redirect::away($checkoutSession->url);
    }

    public function checkoutSuccess($encryptedId)
    {
        $bookingId = decrypt($encryptedId);
        $booking = Booking::with('property')->find($bookingId);
        $booking->update([
            'status' => 'completed',
        ]);

        $booking->property->update([
            'verification_status' => 'Sold',
        ]);
        return view('checkout.success', compact('booking')); // Will create this view
    }

    public function checkoutCancel($encryptedId)
    {
        $bookingId = decrypt($encryptedId);
        $booking = Booking::find($bookingId);

        return view('checkout.cancel', compact('booking')); // Will create this view
    }


}
