<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vitals extends Model
{
    protected $table = 'vitals'; // make sure this matches your table name

    protected $fillable = [
        'checkup_patient_id', // FIXED: must match your foreign key in checkup_patients table
        'checkup_id',
        'height',
        'weight',
        'blood_pressure',
        'pulse_rate',
        'temperature',
        'respiratory_rate',
        'bmi',
    ];

    // Relationship to the pivot table (CheckupPatient)
    public function checkupPatient()
    {
        return $this->belongsTo(CheckupPatient::class, 'checkup_patient_id');
    }

    // Optional: Relationship to the checkup itself (through pivot)
    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_patient_id', 'id');
    }
}
