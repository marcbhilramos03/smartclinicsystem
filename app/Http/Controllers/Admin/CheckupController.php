<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\User;
use App\Models\CourseInformation;

class CheckupController extends Controller
{
    // Show all checkups
    public function index()
    {
        $checkups = Checkup::with(['staff', 'courseInformation'])->latest()->get();

        return view('admin.checkups.index', compact('checkups'));
    }

    // Show create form
    public function create()
    {
    $staff = User::whereIn('role', ['staff'])->get();
        $courses = CourseInformation::all();

        return view('admin.checkups.create', compact('staff', 'courses'));
    }

    // Store new checkup
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:users,user_id',
            'course_information_id' => 'required|exists:course_information,id',
            'checkup_type' => 'required|in:vital,dental',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Checkup::create([
            'admin_id' => auth()->user()->user_id,
            'staff_id' => $request->staff_id,
            'course_information_id' => $request->course_information_id,
            'checkup_type' => $request->checkup_type,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.checkups.index')->with('success', 'Checkup created successfully.');
    }

    // Show checkup details
    public function show($id)
    {
        $checkup = Checkup::with(['staff', 'courseInformation'])->findOrFail($id);

        return view('admin.checkups.show', compact('checkup'));
    }

    // Delete checkup
    public function destroy($id)
    {
        $checkup = Checkup::findOrFail($id);
        $checkup->delete();

        return redirect()->route('admin.checkups.index')->with('success', 'Checkup deleted successfully.');
    }
}
