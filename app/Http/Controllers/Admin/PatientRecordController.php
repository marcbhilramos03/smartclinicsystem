<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ✅ Correct place
use App\Http\Controllers\Controller;

class PatientRecordController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Subquery: latest session per patient
        $latestSession = DB::table('clinic_sessions')
            ->select('user_id', DB::raw('MAX(session_date) as latest_session_date'))
            ->groupBy('user_id');

        // Main query
        $patients = User::where('role', 'patient')
            ->joinSub($latestSession, 'latest_sessions', function ($join) {
                $join->on('users.user_id', '=', 'latest_sessions.user_id');
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.first_name', 'like', "%$search%")
                      ->orWhere('users.last_name', 'like', "%$search%")
                      ->orWhere('users.phone_number', 'like', "%$search%");
                });
            })
            ->orderByDesc('latest_sessions.latest_session_date')
            ->with(['clinicSessions' => function ($q) {
                $q->latest('session_date');
            }])
            ->paginate(10); // ✅ paginate works here

        return view('admin.patients.index', compact('patients', 'search'));
    }

   public function show(User $patient)
{
    // Load main patient info
    $patient->load('personalInformation');

    // Paginate clinic sessions
    $clinicSessions = $patient->clinicSessions()
        ->with('admin')
        ->orderBy('session_date', 'desc')
        ->paginate(5, ['*'], 'clinic_page'); // unique page name for separate pagination

    // Paginate checkups
    $checkups = $patient->checkups()
        ->with([
            'staff',
            'checkupPatients.vitals',
            'checkupPatients.dentals',
            'checkupPatients.patient'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(5, ['*'], 'checkup_page'); // unique page name

    // Paginate medical histories
    $medicalHistories = $patient->medicalHistories()
        ->with('admin')
        ->orderBy('created_at', 'desc')
        ->paginate(5, ['*'], 'history_page'); // unique page name

    return view('admin.patients.show', compact(
        'patient',
        'clinicSessions',
        'checkups',
        'medicalHistories'
    ));
}
// Clinic Sessions
public function allClinicSessions(User $patient)
{
    $clinicSessions = $patient->clinicSessions()->latest()->get();
    return view('admin.patients.all_clinic_sessions', compact('patient', 'clinicSessions'));
}

// Medical Histories
public function allMedicalHistories(User $patient)
{
    $medicalHistories = $patient->medicalHistories()->latest()->get();
    return view('admin.patients.all_medical_histories', compact('patient', 'medicalHistories'));
}
public function allVitals(User $patient)
{
    // Fetch all vitals related to this patient
    $vitals = $patient->vitals()
        ->with(['checkupPatient.checkup.staff'])
        ->latest()
        ->get();

    return view('admin.patients.all_vitals', compact('patient', 'vitals'));
}

public function allDentals(User $patient)
{
    // Fetch all dental records related to this patient
    $dentals = $patient->dentals()
        ->with(['checkupPatient.checkup.staff'])
        ->latest()
        ->get();

    return view('admin.patients.all_dentals', compact('patient', 'dentals'));
}




}
