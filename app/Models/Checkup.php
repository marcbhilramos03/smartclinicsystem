<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'date',
        'course',
        'grade_level',
        'notes',
        'checkup_type',
    ];

    // Relationship: patient (student)
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: staff (doctor/nurse)
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    // Relationship: vitals
    public function vitals()
    {
        return $this->hasOne(Vital::class);
    }

    // Relationship: dental
    public function dental()
    {
        return $this->hasOne(Dental::class);
    }
}
