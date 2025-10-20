<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\Checkup;
use App\Models\ClinicSession;
use Illuminate\Support\Facades\Auth;

class RecordsController extends Controller
{public function index()
{
    $userId = Auth::id();

    $medicalHistories = MedicalHistory::where('user_id', $userId)
        ->with('admin')
        ->latest('date_recorded')
        ->get();

    // Fetch checkups for the current student through the pivot table
    $checkups = Checkup::whereHas('students', function ($query) use ($userId) {
        $query->where('users.user_id', $userId);
    })
    ->with(['staff', 'vitals', 'dentals'])
    ->latest('date')
    ->get();

    $clinicSessions = ClinicSession::where('user_id', $userId) // if clinic_sessions table has user_id
        ->with('admin')
        ->latest('session_date')
        ->get();

    return view('patient.medical_records', compact('medicalHistories', 'checkups', 'clinicSessions'));
}


    public function show($type, $id)
    {
        switch ($type) {
            case 'history':
                $record = MedicalHistory::with('admin')->findOrFail($id);
                $viewType = 'Medical History';
                break;

            case 'checkup':
                $record = Checkup::with(['staff', 'vitals', 'dental'])->findOrFail($id);
                $viewType = 'Checkup';
                break;

            case 'clinic':
                $record = ClinicSession::with('admin')->findOrFail($id);
                $viewType = 'Clinic Session';
                break;

            default:
                abort(404);
        }

        return view('patient.medical_record_show', compact('record', 'viewType', 'type'));
    }
}
