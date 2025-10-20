<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckupController extends Controller
{
    // List all checkups for this admin
    public function index()
    {
        $checkups = Checkup::where('admin_id', auth()->user()->user_id)
                           ->with(['staff', 'course'])
                           ->orderBy('date', 'desc')
                           ->get();

        return view('admin.checkups.index', compact('checkups'));
    }

    // Show form to create a new checkup
    public function create()
    {
        $staff = User::where('role', 'staff')->get();
        $courses = DB::table('course_information')->get();

        return view('admin.checkups.create', compact('staff', 'courses'));
    }

    // Store the checkup
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:users,user_id',
            'course_information_id' => 'required|exists:course_information,id',
            'checkup_type' => 'required|in:vital,dental',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $checkup = Checkup::create([
            'admin_id' => auth()->user()->user_id,
            'staff_id' => $request->staff_id,
            'course_information_id' => $request->course_information_id,
            'checkup_type' => $request->checkup_type,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('checkups.show', $checkup->id)
                         ->with('success', 'Checkup created successfully.');
    }

    // Show checkup details
    public function show($checkupId)
    {
        $checkup = Checkup::with(['staff', 'course', 'students.patient'])
                          ->findOrFail($checkupId);

        return view('admin.checkups.show', compact('checkup'));
    }

    // Show form to edit a checkup
    public function edit($checkupId)
    {
        $checkup = Checkup::findOrFail($checkupId);
        $staff = User::where('role', 'staff')->get();
        $courses = DB::table('course_information')->get();

        return view('admin.checkups.edit', compact('checkup', 'staff', 'courses'));
    }

    // Update the checkup
    public function update(Request $request, $checkupId)
    {
        $request->validate([
            'staff_id' => 'required|exists:users,user_id',
            'course_information_id' => 'required|exists:course_information,id',
            'checkup_type' => 'required|in:vital,dental',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $checkup = Checkup::findOrFail($checkupId);

        $checkup->update([
            'staff_id' => $request->staff_id,
            'course_information_id' => $request->course_information_id,
            'checkup_type' => $request->checkup_type,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.checkups.show', $checkup->id)
                         ->with('success', 'Checkup updated successfully.');
    }

    // Delete the checkup
    public function destroy($checkupId)
    {
        $checkup = Checkup::findOrFail($checkupId);

        // Optional: delete related checkup_patient records
        $checkup->students()->delete();

        $checkup->delete();

        return redirect()->route('admin.checkups.index')
                         ->with('success', 'Checkup deleted successfully.');
    }
}
