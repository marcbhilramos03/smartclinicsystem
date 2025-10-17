<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckupController extends Controller
{
    // List all checkups
    public function index()
    {
        $checkups = Checkup::with(['patient', 'staff'])->paginate(10);
        return view('admin.checkups.index', compact('checkups'));
    }

    // Show form to create checkup
    public function create()
    {
        $students = User::where('role', 'patient')->get();
        $staffs = User::where('role', 'staff')->get();
        return view('admin.checkups.create', compact('students', 'staffs'));
    }

    // Store checkup
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id', // individual student
            'staff_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'checkup_type' => 'required|string',
            'course' => 'nullable|string',        // batch scheduling
            'grade_level' => 'nullable|string',   // batch scheduling
        ]);

        // Individual checkup
        if ($validated['user_id']) {
            Checkup::create($validated);
        } else {
            // Batch checkup: get students from personal information
            $students = User::where('role', 'patient')
                ->join('personal_informations', 'users.id', '=', 'personal_informations.user_id')
                ->when($validated['course'], fn($q) => $q->where('personal_informations.course', $validated['course']))
                ->when($validated['grade_level'], fn($q) => $q->where('personal_informations.grade_level', $validated['grade_level']))
                ->select('users.*')
                ->get();

            if ($students->isEmpty()) {
                return redirect()->back()->with('error', 'No students found for the selected course/grade level.');
            }

            DB::transaction(function() use ($students, $validated) {
                foreach ($students as $student) {
                    Checkup::create([
                        'user_id' => $student->id,
                        'staff_id' => $validated['staff_id'],
                        'date' => $validated['date'],
                        'notes' => $validated['notes'] ?? null,
                        'checkup_type' => $validated['checkup_type'],
                        'course' => $student->personal_information->course ?? null,
                        'grade_level' => $student->personal_information->grade_level ?? null,
                    ]);
                }
            });
        }

        return redirect()->route('admin.checkups.index')->with('success', 'Checkup(s) scheduled successfully.');
    }

    // Optional: show checkup details
    public function show(Checkup $checkup)
    {
        $checkup->load(['patient', 'staff', 'vitals', 'dental']);
        return view('admin.checkups.show', compact('checkup'));
    }

    // Optional: delete a checkup
    public function destroy(Checkup $checkup)
    {
        $checkup->delete();
        return redirect()->route('admin.checkups.index')->with('success', 'Checkup deleted successfully.');
    }
}
