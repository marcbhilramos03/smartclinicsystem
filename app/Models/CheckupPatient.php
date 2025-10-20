<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'patient_id',
    ];

    /**
     * The checkup this record belongs to
     */
    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    /**
     * The user (student) who is the patient
     */
    public function patient()
    {
        // assuming 'users.user_id' is your student’s primary key, not 'id'
        return $this->belongsTo(User::class, 'patient_id', 'user_id');
    }

    /**
     * Vital record for this checkup-patient
     */
    public function vitals()
    {
        return $this->hasOne(Vital::class, 'checkup_patient_id');
    }

    /**
     * Dental record for this checkup-patient
     */
    public function dental()
    {
        return $this->hasOne(Dental::class, 'checkup_patient_id');
    }
}
