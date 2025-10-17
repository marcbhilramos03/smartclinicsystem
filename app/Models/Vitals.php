<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'height',
        'weight',
        'blood_pressure',
        'pulse_rate',
        'temperature',
    ];

    // Relationship: belongs to checkup
    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }
}
