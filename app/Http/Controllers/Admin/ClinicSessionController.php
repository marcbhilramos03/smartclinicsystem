<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClinicSession;
use App\Models\MedicalRecord;
use App\Http\Controllers\Controller;

class ClinicSessionController extends Controller
{

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
        'user_id'      => $patient->user_id,          
        'admin_id'     => auth()->user()->user_id, 
        'session_date' => Carbon::parse($validated['session_date'])->format('Y-m-d'),
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
}
