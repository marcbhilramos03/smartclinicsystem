<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ You forgot this import
use App\Models\User;
use App\Models\Checkup;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ✅ Total counts
        $totalStaff = User::where('role', 'staff')->count();
        $totalPatients = User::where('role', 'patient')->count();
        $totalUsers = User::count();

        $totalCheckups = Checkup::count();
        $vitalsCheckups = Checkup::where('checkup_type', 'vitals')->count();
        $dentalCheckups = Checkup::where('checkup_type', 'dental')->count();

        // ✅ Monthly statistics for charts
        $months = [];
        $patientsData = [];
        $vitalsData = [];
        $dentalData = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $patientsData[] = User::where('role', 'patient')
                ->whereMonth('created_at', $i)
                ->count();
            $vitalsData[] = Checkup::where('checkup_type', 'vitals')
                ->whereMonth('date', $i)
                ->count();
            $dentalData[] = Checkup::where('checkup_type', 'dental')
                ->whereMonth('date', $i)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalStaff',
            'totalPatients',
            'totalUsers',
            'totalCheckups',
            'vitalsCheckups',
            'dentalCheckups',
            'months',
            'patientsData',
            'vitalsData',
            'dentalData'
        ));
    }

    // ✅ For AJAX realtime updates
    public function getStats()
    {
        return response()->json([
            'totalStaff' => User::where('role', 'staff')->count(),
            'totalPatients' => User::where('role', 'patient')->count(),
            'totalUsers' => User::count(),
            'totalCheckups' => Checkup::count(),
            'vitalsCheckups' => Checkup::where('checkup_type', 'vitals')->count(),
            'dentalCheckups' => Checkup::where('checkup_type', 'dental')->count(),
        ]);
    }

    // ✅ Admin Profile Page
    public function profile()
    {
        $admin = Auth::user(); // You need Auth import for this to work
        return view('admin.profile', compact('admin'));
    }

    // ✅ Update Profile Logic
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->user_id,
        ]);

        $user->update($request->only(['first_name', 'last_name', 'email']));

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
}
