<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CheckupPatient;
use App\Models\ClinicSession;
use App\Models\MedicalHistory;

class PatientMedicalRecordController extends Controller
{
    public function index()
    {
        $patient = Auth::user(); // logged-in patient

        // -----------------------------
        // 1. Fetch Checkups (with Vitals & Dentals)
        // -----------------------------
        $checkups = CheckupPatient::with(['checkup.staff', 'vitals', 'dentals'])
            ->where('patient_id', $patient->user_id)
            ->orderByDesc('created_at')
            ->get();

        // -----------------------------
        // 2. Fetch Clinic Sessions
        // -----------------------------
        $clinicSessions = ClinicSession::where('user_id', $patient->user_id)
            ->orderByDesc('session_date')
            ->get();

        // -----------------------------
        // 3. Fetch Medical History
        // -----------------------------
        $medicalHistories = MedicalHistory::where('user_id', $patient->user_id)
            ->orderByDesc('date_recorded')
            ->get();

        return view('patient.medical_records.index', compact(
            'patient', 'checkups', 'clinicSessions', 'medicalHistories'
        ));
    }
}
