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
        $patient->load([
            'personalInformation',
            'medicalHistories.admin',
            'clinicSessions.admin',
            'checkups.staff',
            'checkups.checkupPatients.vitals',   // load vitals through checkupPatients
            'checkups.checkupPatients.dentals',  // load dental through checkupPatients
            'checkups.checkupPatients.patient',  // load patient info for each checkupPatient
        ]);

        return view('admin.patients.show', compact('patient'));
    }
}
