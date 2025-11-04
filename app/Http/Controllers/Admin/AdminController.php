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
    $admin = Auth::user()->load('credential'); // eager load the related credentials
    return view('admin.profile', compact('admin'));    
}

public function updateProfile(Request $request)
{
    $admin = auth()->user(); // current logged-in admin

    // ✅ Validation rules
    $validated = $request->validate([
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'email'          => 'required|email|max:255|unique:users,email,' . $admin->user_id . ',user_id',
        'profession'     => 'nullable|string|max:255',
        'license_type'   => 'nullable|string|max:255',
        'specialization' => 'nullable|string|max:255',
    ]);

    // ✅ Update admin info in users table
    $admin->update([
        'first_name' => $validated['first_name'],
        'last_name'  => $validated['last_name'],
        'email'      => $validated['email'],
    ]);

    // ✅ Update or create credential record for this admin
    $credential = $admin->credential; // Check if admin has existing credential record

    if ($credential) {
        // Update existing credential
        $credential->update([
            'profession'     => $validated['profession'] ?? null,
            'license_type'   => $validated['license_type'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
        ]);
    } else {
        // Create new credential for admin
        $admin->credential()->create([
            'staff_id'       => $admin->user_id,
            'profession'     => $validated['profession'] ?? null,
            'license_type'   => $validated['license_type'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
        ]);
    }

    return redirect()->route('admin.profile')->with('success', 'Admin profile and credentials updated successfully.');
}


}
