<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'session_date',
        'reason',
        'remedy'
        
    ];

    /**
     * Patient (student) of the session
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Staff handling the session
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }

    /**
     * Medications prescribed in this session
     */
    public function medications()
    {
        return $this->hasMany(Medication::class, 'session_id', 'id');
    }
    /**
     * The medical record this session is associated with.
     */
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }
}
