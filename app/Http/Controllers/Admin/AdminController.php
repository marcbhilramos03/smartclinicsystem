<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

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
    $totalStaff = User::where('role', 'staff')->count();
    $totalPatients = User::where('role', 'patient')->count();
    $totalUsers = User::count(); // total users including admin

    // Example chart data
    $patientsLabels = ['Jan', 'Feb', 'Mar', 'Apr'];
    $patientsData = [10, 15, 12, 20];

    $inventoryLabels = ['Medicine A', 'Medicine B', 'Medicine C'];
    $inventoryData = [50, 30, 20];

    return view('admin.dashboard', compact(
        'totalStaff', 'totalPatients', 'totalUsers',
        'patientsLabels', 'patientsData',
        'inventoryLabels', 'inventoryData'
    ));

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
