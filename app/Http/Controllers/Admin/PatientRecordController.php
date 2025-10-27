<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PatientRecordController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $patients = User::where('role', 'patient')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%")
                      ->orWhere('phone_number', 'like', "%$search%");
                });
            })
            ->orderBy('last_name')
            ->paginate(10);

        return view('admin.patients.index', compact('patients', 'search'));
    }
    public function show(User $patient)
{
    $patient->load([
        'personalInformation',
        'medicalHistories.admin',
        'clinicSessions.admin',
        'checkups.staff',
        'checkups.checkupPatients.vitals',   // load vitals through checkupPatients
        'checkups.checkupPatients.dentals',  // load dental through checkupPatients
        'checkups.checkupPatients.patient', // load patient info for each checkupPatient
    ]);

    return view('admin.patients.show', compact('patient'));
}

}
