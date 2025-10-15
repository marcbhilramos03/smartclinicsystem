<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClinicSession;
use App\Models\MedicalHistory;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;

class PatientRecordController extends Controller
{
    // Search & list students
    public function index(Request $request)
    {
       $query = $request->input('query');
        $students = User::where('role', 'patient') // or 'student' if you prefer
            ->whereHas('PersonalInformation', function($q) use ($query) {
                if ($query) {
                    $q->where('school_id', 'like', "%$query%");
                }
            })
            ->paginate(10);


        return view('admin.patients.index', compact('students', 'query'));
    }

    // Show student and their records
public function show(User $user)
{
    $user->load([
        'personalInformation.emergencyContacts', // load personal info + emergency contact
        'clinicSessions',                       // clinic sessions
        'medicalHistories'                      // medical histories
    ]);

    return view('admin.patients.show', compact('user'));
}

    // Show form to add new record (clinic session or medical history)
    public function createRecord(User $user)
    {
        return view('admin.patients.create_record', compact('user'));
    }

    // Store record
   public function storeRecord(Request $request, User $user)
{
    $type = $request->input('record_type');

    if ($type === 'clinic_session') {
        $validated = $request->validate([
            'session_date' => 'required|date',
            'reason' => 'required|string',
            'remedy' => 'nullable|string',
            'medications' => 'nullable|array', 
            'medications.*.inventory_id' => 'required_with:medications|exists:inventory,id',
            'medications.*.dosage' => 'nullable|string',
            'medications.*.duration' => 'nullable|string',
            'medications.*.quantity' => 'nullable|integer|min:1',
        ]);
         MedicalRecord::create([
        'user_id' => $user->user_id,
        'clinic_session_id' => $session->id,
         ]);
        // Create the clinic session
        $session = ClinicSession::create([
            'user_id' => $user->user_id,
            'staff_id' => auth()->user()->user_id, // admin in-charge
            'session_date' => $validated['session_date'],
            'reason' => $validated['reason'],
            'remedy' => $validated['remedy'] ?? null,
        ]);

        // Create medications if provided
        if (!empty($validated['medications'])) {
            foreach ($validated['medications'] as $med) {
                $session->medications()->create([
                    'inventory_id' => $med['inventory_id'],
                    'dosage' => $med['dosage'] ?? null,
                    'duration' => $med['duration'] ?? null,
                    'quantity' => $med['quantity'] ?? 1,
                ]);
            }
        }

    } elseif ($type === 'medical_history') {
        $validated = $request->validate([
            'history_type' => 'required|in:allergy,illness,vaccination',
            'description' => 'required|string',
            'date_recorded' => 'nullable|date',
        ]);

        MedicalHistory::create(array_merge($validated, [
            'user_id' => $user->user_id
        ]));
        
        $history = MedicalHistory::create(array_merge($validated, [
            'user_id' => $user->user_id
        ]));
        MedicalRecord::create([
            'user_id' => $user->user_id,
            'medical_history_id' => $history->id,
    ]);
    }

    return redirect()->route('admin.patients.show', $user)
                     ->with('success', 'Record added successfully.');
}
}

