<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MedicalRecord extends Model
{
    protected $fillable = [
        'user_id', 
        'checkup_id', 
        'vitals_id', 
        'dental_id',
        'clinic_session_id', 
        'medical_history_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id');
    }

    public function clinicSession()
    {
        return $this->belongsTo(ClinicSession::class, 'clinic_session_id');
    }

    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class, 'medical_history_id');
    }
}

