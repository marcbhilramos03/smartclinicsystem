<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\CheckupPatient;
use App\Models\Vitals;
use App\Models\Dental;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;

class StaffCheckupRecordController extends Controller
{
    // Show form to add/edit record
    public function addRecordForm($checkupId, $studentId)
    {
        $checkupPatient = CheckupPatient::firstOrCreate([
            'checkup_id' => $checkupId,
            'patient_id' => $studentId
        ]);

        $checkupPatient->load(['checkup', 'patient', 'vitals', 'dentals']);

        return view('staff.checkups.add_records', compact('checkupPatient'));
    }

    // Store or update vitals/dental
    public function storeRecord(Request $request, $checkupId, $studentId)
    {
        // Ensure checkup exists
        $checkup = Checkup::findOrFail($checkupId);

        // Ensure CheckupPatient exists
        $checkupPatient = CheckupPatient::firstOrCreate([
            'checkup_id' => $checkupId,
            'patient_id' => $studentId
        ]);

        // Handle Vitals
        if ($checkup->checkup_type === 'vitals') {
            $validated = $request->validate([
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'blood_pressure' => 'nullable|string|max:20',
                'pulse_rate' => 'nullable|integer',
                'temperature' => 'nullable|numeric',
                'respiratory_rate' => 'nullable|numeric',
                'bmi' => 'nullable|numeric',
            ]);

           $vitals = Vitals::updateOrCreate(
    ['checkup_patient_id' => $checkupPatient->id],
    array_merge($validated, [
        'checkup_id' => $checkupId,
        'checkup_patient_id' => $checkupPatient->id, // MUST include here
    ])
);

            // Update MedicalRecord
            MedicalRecord::updateOrCreate(
                [
                    'checkup_id' => $checkupId,
                    'patient_id' => $studentId,
                    'staff_id'   => $checkup->staff_id,
                ],
                [
                    'vitals_id'       => $vitals->id,
                    'admin_id'        => Auth::user()->user_id,
                    'recordable_type' => Checkup::class,
                    'recordable_id'   => $checkupId
                ]
            );
        }

        // Handle Dental
        if ($checkup->checkup_type === 'dental') {
            $validated = $request->validate([
                'dental_status'   => 'nullable|string|max:255',
                'needs_treatment' => 'required|in:yes,no',
                'treatment_type'  => 'nullable|string|max:255',
                'note'            => 'nullable|string',
            ]);

           $dental = Dental::updateOrCreate(
    ['checkup_patient_id' => $checkupPatient->id], // condition
    array_merge($validated, [
        'checkup_id' => $checkupId,
        'checkup_patient_id' => $checkupPatient->id, // MUST include here too
    ])
);

            // Update MedicalRecord
            MedicalRecord::updateOrCreate(
                [
                    'checkup_id' => $checkupId,
                    'patient_id' => $studentId,
                    'staff_id'   => $checkup->staff_id,
                ],
                [
                    'dentals_id'      => $dental->id,
                    'admin_id'        => Auth::user()->user_id,
                    'recordable_type' => Checkup::class,
                    'recordable_id'   => $checkupId
                ]
            );
        }

        // Mark checkup patient as Done
        if ($checkupPatient->status === 'Pending') {
            $checkupPatient->status = 'Done';
            $checkupPatient->save();
        }

        return redirect()->route('staff.checkups.students', $checkupId)
                         ->with('success', 'Record saved successfully.');
    }
}
