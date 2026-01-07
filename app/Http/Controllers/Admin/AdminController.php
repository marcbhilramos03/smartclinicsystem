<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Checkup;
use Illuminate\Http\Request;
use App\Models\ClinicSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 

class AdminController extends Controller
{
  
public function dashboard()
{

    $totalStaff = User::where('role', 'staff')->count();
    $totalPatients = User::where('role', 'patient')->count();
    $totalUsers = User::count();
    $totalClinicVisits = ClinicSession::count(); 

    
    $months = [];
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date('M', mktime(0, 0, 0, $i, 1));
    }

    
    $courses = \DB::table('personal_information')
        ->distinct()
        ->pluck('course');

    $courseData = [];
    foreach ($courses as $course) {
        $monthlyCounts = [];
        for ($m = 1; $m <= 12; $m++) {
            $count = ClinicSession::join('personal_information', 'personal_information.user_id', '=', 'clinic_sessions.user_id')
                ->where('personal_information.course', $course)
                ->whereMonth('clinic_sessions.session_date', $m)
                ->count();
            $monthlyCounts[] = $count;
        }
        $courseData[$course] = $monthlyCounts;
    }

    return view('admin.dashboard', compact(
        'totalStaff',
        'totalPatients',
        'totalUsers',
        'totalClinicVisits',
        'months',
        'courses',
        'courseData'
    ));
}
public function getStats()
{
    return response()->json([
        'totalStaff' => User::where('role', 'staff')->count(),
        'totalPatients' => User::where('role', 'patient')->count(),
        'totalUsers' => User::count(),
        'totalClinicVisits' => ClinicSession::count(),
    ]);
}



  public function profile()
{
    $admin = Auth::user()->load('credential'); 
    return view('admin.profile', compact('admin'));    
}

public function updateProfile(Request $request)
{
    $admin = auth()->user(); 


    $validated = $request->validate([
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'email'          => 'required|email|max:255|unique:users,email,' . $admin->user_id . ',user_id',
        'profession'     => 'nullable|string|max:255',
        'license_type'   => 'nullable|string|max:255',
        'specialization' => 'nullable|string|max:255',
    ]);


    $admin->update([
        'first_name' => $validated['first_name'],
        'last_name'  => $validated['last_name'],
        'email'      => $validated['email'],
    ]);

    
    $credential = $admin->credential; 

    if ($credential) {
      
        $credential->update([
            'profession'     => $validated['profession'] ?? null,
            'license_type'   => $validated['license_type'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
        ]);
    } else {
       
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
