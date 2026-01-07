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
    public function addRecordForm($checkupId, $studentId)
    {
        $checkupPatient = CheckupPatient::firstOrCreate([
            'checkup_id' => $checkupId,
            'patient_id' => $studentId
        ]);

        $checkupPatient->load(['checkup', 'patient', 'vitals', 'dentals']);

        return view('staff.checkups.add_records', compact('checkupPatient'));
    }

  
    public function storeRecord(Request $request, $checkupId, $studentId)
    {

        $checkup = Checkup::findOrFail($checkupId);

  
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
        'checkup_patient_id' => $checkupPatient->id, 
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
    ['checkup_patient_id' => $checkupPatient->id], 
    array_merge($validated, [
        'checkup_id' => $checkupId,
        'checkup_patient_id' => $checkupPatient->id,
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
 if ($checkupPatient->status === 'pending') {
    $checkupPatient->status = 'completed'; 
    $checkupPatient->save();
}



        return redirect()->route('staff.checkups.students', $checkupId)
                         ->with('success', 'Record saved successfully.');
    }
    // View Records
public function viewRecords(Request $request)
{
    $query = MedicalRecord::with(['patient', 'vitals', 'dentals', 'checkup'])
        ->where('staff_id', Auth::user()->user_id)
        ->orderBy('created_at', 'desc');


    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('patient', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }

    $records = $query->paginate(10)->withQueryString(); 

    return view('staff.records.index', compact('records'));
}


public function viewStudents(Request $request)
{
    $query = CheckupPatient::with(['patient', 'checkup'])
        ->whereHas('checkup', function($q) {
            $q->where('staff_id', Auth::user()->user_id);
        });

    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('patient', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }

    $students = $query->orderBy('status', 'asc')->paginate(10)->withQueryString();

    return view('staff.students.index', compact('students'));
}
}
