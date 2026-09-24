<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payout;
use App\Models\CommissionSetting;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return view('dashboard.admin');
        } 

        if ($user->hasRole('property-team')) {
            return view('dashboard.team');
        }

        if ($user->hasRole('vendor')) {
            return view('dashboard.vendor');
        }

        return view('dashboard.renter');
    }

    public function commissions()
    {
        $bookings = Booking::where('vendor_id', auth()->user()->id)->where('status', 'confirmed')->with(['property', 'payout'])->get();
        return view('vendor.commission', compact('bookings'));
    }

    public function payoutRequest(Booking $booking)
    {
        $payouts = Payout::where('booking_id', $booking->id)->where('status', 'pending')->get();

        if($payouts->count() > 0)
        {
            return redirect()->back()->with('error', 'Payout request already submitted');
        }else{
            $commissionSetting = CommissionSetting::latest()->first();
            $propertyPrice = $booking->property->price ?? 0;
                                    
            $commission = $propertyPrice * ($commissionSetting->value / 100); 
            $total = ($propertyPrice-$commission);  

            $payout = new Payout();
            $payout->booking_id = $booking->id;
            $payout->amount = $total;
            $payout->status = 'pending';
            $payout->save();
        }
        return redirect()->back()->with('success', 'Payout request submitted successfully');
        
    }
}