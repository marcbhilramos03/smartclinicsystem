<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vitals extends Model
{
    protected $table = 'vitals';

    protected $fillable = [
        'checkup_patient_id',
        'checkup_id',
        'height',
        'weight',
        'blood_pressure',
        'pulse_rate',
        'temperature',
        'respiratory_rate',
        'bmi',
    ];

    public function checkupPatient()
    {
        return $this->belongsTo(CheckupPatient::class, 'checkup_patient_id');
    }

    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_patient_id', 'id');
    }
}
