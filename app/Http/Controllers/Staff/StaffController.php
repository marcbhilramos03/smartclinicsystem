<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'role:staff']);
    // }
    public function dashboard()
    {
        return view('staff.dashboard');
    }
    // Staff profile page
    public function profile()
    {
        $user = auth()->user();
        return view('staff.profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // add other fields if needed
        ]);

        $user->update($request->only(['first_name', 'last_name', 'email']));

        return redirect()->route('staff.dashboard')->with('success', 'Profile updated successfully.');
    }
}
