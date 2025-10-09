<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Constructor to add auth & role middleware (optional if already applied in routes)
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'role:admin']);
    // }

    // Admin profile page
    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }
        public function dashboard()
    {
        return view('admin.dashboard');
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

        return redirect()->route('admin.dashboard')->with('success', 'Profile updated successfully.');
    }
}
