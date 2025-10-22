<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Checkup;           // <-- add this

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class AdminController extends Controller
{
  public function dashboard()
{
    $totalStaff = User::where('role', 'staff')->count();
    $totalPatients = User::where('role', 'patient')->count();
    $totalUsers = User::count();

    $totalCheckups = Checkup::count();
    $vitalsCheckups = Checkup::where('checkup_type', 'vitals')->count();
    $dentalCheckups = Checkup::where('checkup_type', 'dental')->count();

    $months = [];
    $patientsData = [];
    $vitalsData = [];
    $dentalData = [];

    for ($i = 1; $i <= 12; $i++) {
        $months[] = date('M', mktime(0,0,0,$i,1));
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
        'totalStaff','totalPatients','totalUsers',
        'totalCheckups','vitalsCheckups','dentalCheckups',
        'months','patientsData','vitalsData','dentalData'
    ));
}

public function profile()
    {
        // Assuming you store admin in users table with role='admin'
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
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
