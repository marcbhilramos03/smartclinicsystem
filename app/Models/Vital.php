<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_patient_id',
        'checkup_id',
        'patient_id',
        'height',
        'weight',
        'blood_pressure',
        'pulse_rate',
        'temperature',
        'respiratory_rate',
        'bmi',
    ];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'user_id');
    }
    public function checkupPatient()
    {
    return $this->belongsTo(CheckupPatient::class, 'checkup_patient_id');
    }
}
