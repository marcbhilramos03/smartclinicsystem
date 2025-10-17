<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dental extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'dental_status',
        'cavities',
        'missing_teeth',
        'gum_disease',
        'oral_hygiene',
        'notes',
    ];

    // Relationship: belongs to checkup
    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }
}
