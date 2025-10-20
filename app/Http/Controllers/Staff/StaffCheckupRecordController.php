<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Checkup, CheckupPatient, User, Vital, Dental};

class StaffCheckupRecordController extends Controller
{
    /**
     * Show list of students (patients) for this checkup
     */
    public function students($checkupId)
    {
        $checkup = Checkup::with('course')->findOrFail($checkupId);

        // Fetch students whose course matches the checkup’s course
        $students = User::where('role', 'patient')
            ->whereHas('personalInformation.course', function ($query) use ($checkup) {
                $query->where('course', $checkup->course->course);
            })
            ->get();

        return view('staff.checkups.students', compact('checkup', 'students'));
    }

    /**
     * Show form to add a record (vital or dental)
     */
    public function addRecordForm($checkupId, $studentId)
    {
        $checkup = Checkup::findOrFail($checkupId);
        $student = User::findOrFail($studentId);

        // Ensure a checkup-patient record exists (or create one)
        $checkupPatient = CheckupPatient::firstOrCreate([
            'checkup_id' => $checkupId,
            'patient_id' => $studentId,
        ]);

        $checkupType = strtolower($checkup->checkup_type);

        if ($checkupType === 'vital') {
            return view('staff.records.vital_form', compact('checkup', 'student', 'checkupPatient'));
        } elseif ($checkupType === 'dental') {
            return view('staff.records.dental_form', compact('checkup', 'student', 'checkupPatient'));
        } else {
            return back()->with('error', 'Unknown checkup type.');
        }
    }

    /**
     * Store the record (vital or dental)
     */
    public function storeRecord(Request $request, $checkupId, $studentId)
    {
        $checkup = Checkup::findOrFail($checkupId);
        $student = User::findOrFail($studentId);

        // Ensure checkup-patient record exists
        $checkupPatient = CheckupPatient::firstOrCreate([
            'checkup_id' => $checkup->id,
            'patient_id' => $student->user_id,
        ]);

        $checkupPatientId = $checkupPatient->id;
        $type = strtolower($checkup->checkup_type);

        if ($type === 'vital') {
            $validated = $request->validate([
                'height' => 'required|numeric',
                'weight' => 'required|numeric',
                'blood_pressure' => 'required|string',
                'pulse_rate' => 'required|numeric',
                'temperature' => 'required|numeric',
                'respiratory_rate' => 'required|numeric',
                'bmi' => 'nullable|numeric',
            ]);

            Vital::create([
                'checkup_id' => $checkup->id,
                'checkup_patient_id' => $checkupPatientId,
            ] + $validated);
        }

        if ($type === 'dental') {
            $validated = $request->validate([
                'dental_status' => 'nullable|string',
                'cavities' => 'nullable|integer',
                'missing_teeth' => 'nullable|integer',
                'gum_disease' => 'boolean',
                'oral_hygiene' => 'boolean',
                'notes' => 'nullable|string',
            ]);

            Dental::create([
                'checkup_id' => $checkup->id,
                'checkup_patient_id' => $checkupPatientId,
            ] + $validated);
        }

        return redirect()->route('staff.checkups.show', $checkupId)
            ->with('success', ucfirst($type) . ' record added successfully.');
    }
}
