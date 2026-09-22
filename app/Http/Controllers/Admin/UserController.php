<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Models\Inqury;
use App\Services\MailService;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('manage users');
        $users = User::with('roles')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function approveVendor(User $user)
    {
        Gate::authorize('manage vendors');
        $user->status = 1;
        $user->save();
        // vendor ko email jae k apna acount successfuly active ho gya he
        return back()->with('success', 'Vendor approved successfully.');
    }

    public function rejectVendor(User $user)
    {
        Gate::authorize('manage vendors');
        $user->status = 0;
        $user->save();
        return back()->with('success', 'Vendor rejected successfully.');
    }

    public function createPropertyManagementTeamAccount(Request $request)
    {
        Gate::authorize('manage property management team');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('property_management_team');

        return back()->with('success', 'Property Management Team account created successfully.');
    }

    public function edit(User $user)
    {
        Gate::authorize('manage users');
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('manage users');
        $request->validate([
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User roles updated successfully.');
    }

    public function inquries()
    {
        $inquries = Inqury::latest()->get();
        return view('admin.inquries', compact('inquries'));
    }
   
    public function destroy($id)
    {
        $inquiry = Inqury::findOrFail($id);
        $inquiry->delete();

        return redirect()->back()->with('success', 'Inquiry deleted successfully.');
    }
}
