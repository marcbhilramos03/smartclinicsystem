<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\CheckupPatient;
use App\Models\PersonalInformation;
use App\Models\User;

class StaffCheckupController extends Controller
{
    // List all checkups assigned to the logged-in staff
    public function index()
    {
        $staffId = auth()->user()->user_id;

        $checkups = Checkup::with('course', 'staff')
            ->where('staff_id', $staffId)
            ->orderBy('date', 'desc')
            ->get();

        return view('staff.checkups.index', compact('checkups'));
    }
public function show(Request $request, $checkupId)
{
    // Fetch the checkup along with its course
    $checkup = Checkup::with(['staff', 'admin', 'course'])->findOrFail($checkupId);

    // Get the course ID of this checkup
    $courseId = $checkup->course?->id;

    // Fetch only students with the same course
    $students = User::where('role', 'patient')
        ->whereHas('personalInformation.course', function ($q) use ($courseId) {
            if ($courseId) {
                $q->where('id', $courseId);
            }
        })
        ->with('personalInformation.course')
        ->get();

    return view('staff.checkups.show', compact('checkup', 'students'));
}




}
