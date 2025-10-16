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
            'medication' => 'nullable|string', // simple optional medication
        ]);

        // Create the clinic session
        $session = ClinicSession::create([
            'user_id' => $user->user_id,
            'staff_id' => auth()->id(), // current logged-in admin/staff
            'session_date' => $validated['session_date'],
            'reason' => $validated['reason'],
            'remedy' => $validated['remedy'] ?? null,
            'admin_id' => auth()->id(), // who recorded this
        ]);

        // Optional: create medication record if medication field is filled
        if (!empty($validated['medication'])) {
            $session->medications()->create([
                'inventory_id' => null, // optional, if not linked to inventory
                'dosage' => $validated['medication'],
                'duration' => null,
                'quantity' => 1,
            ]);
        }

        // Create MedicalRecord link
        MedicalRecord::create([
            'user_id' => $user->user_id,
            'clinic_session_id' => $session->id,
        ]);

    } elseif ($type === 'medical_history') {
        $validated = $request->validate([
            'history_type' => 'required|in:allergy,illness,vaccination',
            'description' => 'required|string',
            'date_recorded' => 'nullable|date',
        ]);

        $history = MedicalHistory::create([
            'user_id' => $user->user_id,
            'history_type' => $validated['history_type'],
            'description' => $validated['description'],
            'date_recorded' => $validated['date_recorded'] ?? now(),
            'admin_id' => auth()->id(), // current logged-in admin/staff
        ]);

        MedicalRecord::create([
            'user_id' => $user->user_id,
            'medical_history_id' => $history->id,
        ]);
    }

    return redirect()
        ->route('admin.patients.show', $user)
        ->with('success', 'Record added successfully.');
}

}

