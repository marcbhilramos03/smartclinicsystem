<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dental extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_patient_id', // REQUIRED
        'checkup_id',
        'dental_status',
        'needs_treatment',
        'treatment_type',
        'note',
    ];

    // Relation to Checkup
    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id');
    }    
    public function checkupPatient()
    {
        return $this->belongsTo(CheckupPatient::class, 'checkup_patient_id');
    }
}
