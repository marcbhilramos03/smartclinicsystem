<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\CheckupPatient;
use App\Models\Vital;
use App\Models\Dental;
use App\Models\User;

class StaffCheckupRecordController extends Controller
{
    // List students in a checkup (already handled by StaffCheckupController@show)
    public function index($checkupId)
    {
        $checkup = Checkup::findOrFail($checkupId);
        $students = CheckupPatient::with('patient.personalInformation')
            ->where('checkup_id', $checkupId)
            ->get();

        return view('staff.checkup_records.index', compact('checkup', 'students'));
    }

    // Show form to add a record for a student
    public function create($checkupId, $studentId)
    {
        $checkup = Checkup::findOrFail($checkupId);
        $student = User::findOrFail($studentId);

        // Check if record already exists
        $existingRecord = null;
        if ($checkup->type === 'vital') {
            $existingRecord = Vital::where('checkup_id', $checkupId)->where('checkup_patient_id', $studentId)->first();
        } else {
            $existingRecord = Dental::where('checkup_id', $checkupId)->where('checkup_patient_id', $studentId)->first();
        }

        return view('staff.checkup_records.create', compact('checkup', 'student', 'existingRecord'));
    }

    // Store student record
    public function store(Request $request, $checkupId)
    {
        $checkup = Checkup::findOrFail($checkupId);
        $patientId = $request->input('patient_id');

        if ($checkup->type === 'vital') {
            Vital::create([
                'checkup_id' => $checkupId,
                'checkup_patient_id' => $patientId,
                'height' => $request->height,
                'weight' => $request->weight,
                'blood_pressure' => $request->blood_pressure,
                'pulse_rate' => $request->pulse_rate,
                'temperature' => $request->temperature,
                'respiratory_rate' => $request->respiratory_rate,
                'bmi' => $request->bmi,
            ]);
        } else {
            Dental::create([
                'checkup_id' => $checkupId,
                'checkup_patient_id' => $patientId,
                'dental_status' => $request->dental_status,
                'cavities' => $request->cavities,
                'missing_teeth' => $request->missing_teeth,
                'gum_disease' => $request->gum_disease,
                'oral_hygiene' => $request->oral_hygiene,
                'notes' => $request->notes,
            ]);
        }

        return redirect()->route('staff.checkups.show', $checkupId)->with('success', 'Record added successfully.');
    }

    // Show form to edit a record
    public function edit($checkupId, $recordId)
    {
        $checkup = Checkup::findOrFail($checkupId);

        if ($checkup->type === 'vital') {
            $record = Vital::findOrFail($recordId);
        } else {
            $record = Dental::findOrFail($recordId);
        }

        $student = $record->checkupPatient->patient;

        return view('staff.checkup_records.edit', compact('checkup', 'student', 'record'));
    }

    // Update a record
    public function update(Request $request, $checkupId, $recordId)
    {
        $checkup = Checkup::findOrFail($checkupId);

        if ($checkup->type === 'vital') {
            $record = Vital::findOrFail($recordId);
            $record->update($request->only(['height','weight','blood_pressure','pulse_rate','temperature','respiratory_rate','bmi']));
        } else {
            $record = Dental::findOrFail($recordId);
            $record->update($request->only(['dental_status','cavities','missing_teeth','gum_disease','oral_hygiene','notes']));
        }

        return redirect()->route('staff.checkups.show', $checkupId)->with('success', 'Record updated successfully.');
    }

    // Delete a record
    public function destroy($checkupId, $recordId)
    {
        $checkup = Checkup::findOrFail($checkupId);

        if ($checkup->type === 'vital') {
            Vital::findOrFail($recordId)->delete();
        } else {
            Dental::findOrFail($recordId)->delete();
        }

        return redirect()->route('staff.checkups.show', $checkupId)->with('success', 'Record deleted successfully.');
    }
}
