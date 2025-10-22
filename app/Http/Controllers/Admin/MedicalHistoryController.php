<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use App\Models\MedicalRecord;
use App\Models\User;

class MedicalHistoryController extends Controller
{
    public function index()
    {
        $histories = MedicalHistory::with('patient')->latest()->paginate(10);
        return view('admin.medical_histories.index', compact('histories'));
    }

public function create($patientId)
{
    $patient = User::where('role', 'patient')->findOrFail($patientId);

    return view('admin.medical_histories.create', compact('patient'));
}
public function store(Request $request, $patient)
{
    // Make sure the patient exists
    $patient = User::findOrFail($patient);

    // Validate the request
    $validated = $request->validate([
        'history_type' => 'required|in:allergy,illness,vaccination',
        'description'  => 'required|string',
        'notes'        => 'nullable|string',
        'date_recorded'=> 'nullable|date',
    ]);

    $history = MedicalHistory::create([
    'user_id' => $patient->user_id,
    'admin_id' => auth()->user()->user_id,
    'history_type' => $request->history_type,
    'description' => $request->description,
    'date_recorded' => $request->date_recorded,
]);

MedicalRecord::create([
    'patient_id' => $patient->user_id,
    'admin_id' => auth()->user()->user_id,
    'recordable_id' => $history->id,
    'recordable_type' => MedicalHistory::class,
]);

    return redirect()
        ->route('admin.patients.show', $patient->user_id)
        ->with('success', 'Medical history added successfully.');
}


    public function show(MedicalHistory $medicalHistory)
    {
        return view('admin.medical_histories.show', compact('medicalHistory'));
    }
}
