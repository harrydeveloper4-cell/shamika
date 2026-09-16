<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}