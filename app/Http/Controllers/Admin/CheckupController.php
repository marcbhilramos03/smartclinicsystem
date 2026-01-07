<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Checkup;
use App\Models\CheckupPatient;
use App\Models\Vitals;
use App\Models\Dental;
use App\Models\MedicalRecord;
use App\Models\PersonalInformation;

class CheckupController extends Controller
{
    public function index()
    {
        $checkups = Checkup::with([
            'staff',
            'admin',
            'patients.personalInformation'
        ])->orderBy('date', 'desc')->paginate(10);

        return view('admin.checkups.index', compact('checkups'));
    }

    public function create()
    {
        $staff = User::where('role', 'staff')->get();
        $courses = PersonalInformation::select('course')->distinct()->get();
        return view('admin.checkups.create', compact('staff', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,user_id',
            'checkup_type' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'course' => 'required|string',
        ]);

        $students = User::whereHas('personalInformation', function ($query) use ($validated) {
            $query->where('course', $validated['course']);
        })->get();

        if ($students->isEmpty()) {
            return back()->withErrors(['course' => 'No students found for this course.']);
        }

        $checkup = Checkup::create([
            'admin_id' => auth()->user()->user_id,
            'staff_id' => $validated['staff_id'],
            'checkup_type' => $validated['checkup_type'],
            'date' => $validated['date'],
            'notes' => $validated['notes'] ?? null,
            'personal_information_id' => null,
        ]);

        $checkup->patients()->attach($students->pluck('user_id')->toArray());

        foreach ($students as $student) {
            MedicalRecord::create([
                'patient_id' => $student->user_id,
                'admin_id' => auth()->user()->user_id,
                'recordable_id' => $checkup->id,
                'recordable_type' => Checkup::class,
            ]);
        }

        return redirect()->route('admin.checkups.index')
                         ->with('success', 'Checkup scheduled successfully for all students in the course.');
    }

    public function editPatientRecord($checkupPatientId)
    {
        $checkupPatient = CheckupPatient::with(['checkup', 'patient', 'vitals', 'dentals'])
            ->find($checkupPatientId);

        if (!$checkupPatient) {
            return redirect()->route('admin.checkups.index')
                ->with('error', 'Patient record not found.');
        }

        return view('admin.checkups.edit_patient', compact('checkupPatient'));
    }

    public function updatePatientRecord(Request $request, $checkupPatientId)
    {
        $checkupPatient = CheckupPatient::with('checkup')->findOrFail($checkupPatientId);

        $vitals = null;
        $dental = null;

        // -----------------------
        // VITALS RECORD
        if ($checkupPatient->checkup->checkup_type === 'vitals') {
            $validated = $request->validate([
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'blood_pressure' => 'nullable|string|max:20',
                'pulse_rate' => 'nullable|integer',
                'temperature' => 'nullable|numeric',
                'respiratory_rate' => 'nullable|numeric',
                'bmi' => 'nullable|numeric',
            ]);

            if (!empty($validated['height']) && !empty($validated['weight'])) {
                $heightInMeters = $validated['height'] / 100;
                $bmi = round($validated['weight'] / ($heightInMeters * $heightInMeters), 2);
                $validated['bmi'] = $bmi;
            }

            $vitals = Vitals::updateOrCreate(
                ['checkup_patient_id' => $checkupPatient->id],
                array_merge($validated, ['checkup_id' => $checkupPatient->checkup_id])
            );

            $checkupPatient->status = $checkupPatient->vitals()->exists() ? 'completed' : 'incomplete';
            $checkupPatient->save();

            MedicalRecord::updateOrCreate(
                [
                    'checkup_id' => $checkupPatient->checkup_id,
                    'patient_id' => $checkupPatient->patient_id,
                    'staff_id'   => $checkupPatient->checkup->staff_id,
                ],
                [
                    'vitals_id'       => $vitals->id,
                    'admin_id'        => auth()->user()->user_id,
                    'recordable_type' => Checkup::class,
                    'recordable_id'   => $checkupPatient->checkup_id,
                ]
            );
        }


        // DENTAL RECORD
        if ($checkupPatient->checkup->checkup_type === 'dental') {
            $validated = $request->validate([
                'dental_status'   => 'nullable|string|max:255',
                'needs_treatment' => 'required|in:yes,no',
                'treatment_type'  => 'nullable|string|max:255',
                'note'            => 'nullable|string',
            ]);

            $dental = Dental::updateOrCreate(
                ['checkup_patient_id' => $checkupPatient->id],
                array_merge($validated, ['checkup_id' => $checkupPatient->checkup_id])
            );

            $checkupPatient->status = $checkupPatient->dentals()->exists() ? 'completed' : 'incomplete';
            $checkupPatient->save();

            MedicalRecord::updateOrCreate(
                [
                    'checkup_id' => $checkupPatient->checkup_id,
                    'patient_id' => $checkupPatient->patient_id,
                    'staff_id'   => $checkupPatient->checkup->staff_id,
                ],
                [
                    'dentals_id'      => $dental->id,
                    'admin_id'        => auth()->user()->user_id,
                    'recordable_type' => Checkup::class,
                    'recordable_id'   => $checkupPatient->checkup_id,
                ]
            );
        }

        return redirect()->route('admin.checkups.show', $checkupPatient->checkup->id)
                         ->with('success', 'Record saved successfully.');
    }

    public function show($id)
    {
        $checkup = Checkup::with(['staff', 'admin', 'patients.personalInformation', 'vitals', 'dentals'])
                          ->findOrFail($id);

        return view('admin.checkups.show', compact('checkup'));
    }

    public function destroy($id)
    {
        $checkup = Checkup::findOrFail($id);

        $checkup->patients()->detach();

        $checkup->vitals()->delete();
        $checkup->dentals()->delete();

        $checkup->delete();

        return redirect()->route('admin.checkups.index')
                         ->with('success', 'Checkup deleted successfully.');
    }
}
