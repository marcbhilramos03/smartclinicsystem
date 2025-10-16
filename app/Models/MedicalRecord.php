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
        'clinic_session_id'
    ];

    // The patient who owns this record
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // One medical record can have many medical histories
    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class, 'user_id', 'user_id');
    }

    // One record can have many checkups
    public function checkups()
    {
        return $this->hasMany(Checkup::class, 'user_id', 'user_id');
    }

    // One record can have many clinic sessions
    public function clinicSessions()
    {
        return $this->hasMany(ClinicSession::class, 'user_id', 'user_id');
    }
}
