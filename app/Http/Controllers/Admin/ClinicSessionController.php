<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicSession;
use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\Request;

class ClinicSessionController extends Controller
{
    // Show form to add a clinic session for a patient
    public function create(User $patient)
    {
        return view('admin.clinic_sessions.create', compact('patient'));
    }

public function store(Request $request, User $patient)
{
    $validated = $request->validate([
        'session_date' => 'required|date',
        'reason'       => 'required|string|max:255',
        'remedy'       => 'nullable|string|max:500',
    ]);

    // Create the clinic session
    $session = ClinicSession::create([
        'user_id'      => $patient->user_id,          // ✅ must exist
        'admin_id'     => auth()->user()->user_id,   // current admin
        'session_date' => $validated['session_date'],
        'reason'       => $validated['reason'],
        'remedy'       => $validated['remedy'] ,
    ]);

        // Create polymorphic medical record
        MedicalRecord::create([
            'patient_id'      => $patient->user_id,
            'admin_id'        => auth()->user()->user_id,
            'recordable_id'   => $session->id,
            'recordable_type' => ClinicSession::class,
        ]);

        return redirect()->route('admin.patients.show', $patient)
                         ->with('success', 'Clinic session added successfully.');
    }

    // // List all sessions for a patient
    // public function index(User $patient)
    // {
    //     $sessions = ClinicSession::where('user_id', $patient->id)->get();
    //     return view('admin.clinic_sessions.index', compact('sessions', 'patient'));
    // }

    // // Show a single clinic session
    // public function show(User $patient, ClinicSession $clinicSession)
    // {
    //     if ($clinicSession->user_id !== $patient->id) {
    //         abort(404);
    //     }
    //     return view('admin.clinic_sessions.show', compact('clinicSession', 'patient'));
    // }

    // // Delete a clinic session
    // public function destroy(User $patient, ClinicSession $clinicSession)
    // {
    //     if ($clinicSession->user_id !== $patient->id) {
    //         abort(404);
    //     }

    //     $clinicSession->delete();

    //     return redirect()->route('admin.patients.show', $patient)
    //                      ->with('success', 'Clinic session deleted successfully.');
    // }
}
