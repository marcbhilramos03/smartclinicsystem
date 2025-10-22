<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use Illuminate\Support\Facades\Auth;

class StaffCheckupController extends Controller
{
    // List all checkups assigned to this staff
    public function index()
    {
        $checkups = Checkup::where('staff_id', Auth::user()->user_id)
            ->with('patients')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('staff.checkups.index', compact('checkups'));
    }

    // Show students for a particular checkup
public function students($checkupId)
{
    // Fetch the checkup along with assigned patients
    $checkup = \App\Models\Checkup::with('patients.personalInformation')
                ->findOrFail($checkupId);

    // Return a view to list students
    return view('staff.checkups.students', compact('checkup'));
}
public function show($checkupId)
{
    // Fetch checkup with its assigned students
    $checkup = Checkup::with(['patients.personalInformation', 'staff'])
                      ->findOrFail($checkupId);

    // Return a view to show the checkup details and students
    return view('staff.checkups.show', compact('checkup'));
}



}
