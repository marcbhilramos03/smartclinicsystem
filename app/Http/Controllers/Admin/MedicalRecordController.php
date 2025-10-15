<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
       
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Admin (nurse) sees all patient records
            $records = MedicalRecord::with([
                'user.personalInformation',
                'checkup.staff',
                'clinicSession.admin',
                'medicalHistory'
            ])->latest()->paginate(10);

        } elseif ($user->isStaff()) {
            // Staff sees only checkups they performed
            $records = MedicalRecord::whereHas('checkup', function ($q) use ($user) {
                $q->where('staff_id', $user->user_id);
            })->with([
                'user.personalInformation',
                'checkup.staff'
            ])->latest()->paginate(10);

        } else {
            // Patient sees only their own records
            $records = MedicalRecord::where('user_id', $user->user_id)
                ->with([
                    'checkup.staff',
                    'clinicSession.admin',
                    'medicalHistory'
                ])
                ->latest()->paginate(10);
        }

        return view('medical_records.index', compact('records'));
    }

    /**
     * Display a single medical record.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load([
            'user.personalInformation',
            'checkup.staff',
            'clinicSession.admin',
            'medicalHistory',
        ]);

        return view('medical_records.show', compact('medicalRecord'));
    }
}
