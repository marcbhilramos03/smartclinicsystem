<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'checkup_id',
        'vitals_id',
        'dental_id',
        'clinic_session_id',
        'medical_history_id',
    ];

    // The student who owns this record
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Each record may have one clinic session
    public function clinicSession()
    {
        return $this->belongsTo(ClinicSession::class, 'clinic_session_id');
    }

    // Each record may have one checkup
    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id');
    }

    // Each record may have one vitals
    public function vitals()
    {
        return $this->belongsTo(Vitals::class, 'vitals_id');
    }

    // Each record may have one dental
    public function dental()
    {
        return $this->belongsTo(Dental::class, 'dental_id');
    }

    // Each record may have one medical history
    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class, 'medical_history_id');
    }
}

