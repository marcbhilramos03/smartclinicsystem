<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClinicSession;
use App\Models\MedicalHistory;
use App\Models\MedicalRecord;
use App\Http\Controllers\Controller;

class PatientRecordController extends Controller
{
    /**
     * Search & list patients
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $patients = User::where('role', 'patient')
            ->whereHas('personalInformation', function ($q) use ($query) {
                if ($query) {
                    $q->where('school_id', 'like', "%$query%");
                }
            })
            ->paginate(10);

        return view('admin.patients.index', compact('patients', 'query'));
    }

    /**
     * Show full medical record of a patient (including checkups)
     */
    public function show(User $user)
    {
        $user->load([
            'personalInformation.emergencyContacts',
            'clinicSessions.medications.inventory',
            'medicalHistories',
            'checkups.vitals',
            'checkups.dental',
            'checkups.staff',
        ]);

        return view('admin.patients.show', compact('user'));
    }

    /**
     * Show form to add a new record
     */
    public function createRecord(User $user)
    {
        return view('admin.patients.create_record', compact('user'));
    }

    /**
     * Store a clinic session or medical history
     */
    public function storeRecord(Request $request, User $user)
    {
        $type = $request->input('record_type');

        if ($type === 'clinic_session') {
            $validated = $request->validate([
                'session_date' => 'required|date',
                'reason' => 'required|string',
                'remedy' => 'nullable|string',
                'medication' => 'nullable|string',
            ]);

            // Create clinic session
            $session = ClinicSession::create([
                'user_id' => $user->id,
                'staff_id' => auth()->id(),
                'session_date' => $validated['session_date'],
                'reason' => $validated['reason'],
                'remedy' => $validated['remedy'] ?? null,
            ]);

            // Optional medication
            if (!empty($validated['medication'])) {
                $session->medications()->create([
                    'inventory_id' => null,
                    'dosage' => $validated['medication'],
                    'duration' => null,
                    'quantity' => 1,
                ]);
            }

            // Link clinic session to medical record
            MedicalRecord::create([
                'user_id' => $user->id,
                'clinic_session_id' => $session->id,
            ]);

        } elseif ($type === 'medical_history') {
            $validated = $request->validate([
                'history_type' => 'required|in:allergy,illness,vaccination',
                'description' => 'required|string',
                'date_recorded' => 'nullable|date',
            ]);

            $history = MedicalHistory::create([
                'user_id' => $user->id,
                'history_type' => $validated['history_type'],
                'description' => $validated['description'],
                'date_recorded' => $validated['date_recorded'] ?? now(),
                'admin_id' => auth()->id(),
            ]);

            MedicalRecord::create([
                'user_id' => $user->id,
                'medical_history_id' => $history->id,
            ]);
        }

        return redirect()
            ->route('admin.patients.show', $user)
            ->with('success', 'Record added successfully.');
    }
}
