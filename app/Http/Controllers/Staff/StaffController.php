<?php

namespace App\Http\Controllers\Staff;

use App\Models\Checkup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- make sure this is here
use App\Models\CheckupPatient;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class StaffController extends Controller
{
 
public function dashboard()
{
    $staffId = Auth::user()->user_id;

    // Total patients assigned to this staff
    $totalPatients = CheckupPatient::whereHas('checkup', function($q) use ($staffId) {
        $q->where('staff_id', $staffId);
    })->distinct('patient_id')->count('patient_id');

    // Total distinct courses among patients assigned to this staff
    $totalCourses = PersonalInformation::whereIn('user_id', function($q) use ($staffId) {
        $q->select('patient_id')
          ->from('checkup_patients')
          ->join('checkups', 'checkups.id', '=', 'checkup_patients.checkup_id')
          ->where('checkups.staff_id', $staffId);
    })->distinct('course')->count('course');

    // Pending checkups assigned to this staff
    $pendingCheckups = CheckupPatient::where('status', 'pending')
        ->whereHas('checkup', function($q) use ($staffId) {
            $q->where('staff_id', $staffId);
        })->count();

    // Completed checkups assigned to this staff
    $completedCheckups = CheckupPatient::where('status', 'completed')
        ->whereHas('checkup', function($q) use ($staffId) {
            $q->where('staff_id', $staffId);
        })->count();

    return view('staff.dashboard', compact(
        'totalPatients',
        'totalCourses',
        'pendingCheckups',
        'completedCheckups'
    ));
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
