<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vitals extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'height',
        'weight',
        'blood_pressure',
        'pulse_rate',
        'temperature',
        'bmi',
    ];

    // Each vitals record belongs to a checkup
    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id', 'id');
    }
}
