<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;
    protected $casts = [
        'date' => 'date', // now $checkup->date is a Carbon instance
    ];
    protected $fillable = [
        'admin_id',
        'staff_id',
        'course_information_id',
        'checkup_type',
        'date',
        'notes',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(CourseInformation::class, 'course_information_id');
    }

    public function vitals()
    {
        return $this->hasMany(Vital::class);
    }

    public function dental()
    {
        return $this->hasMany(Dental::class);
    }
    public function students()
{
    return $this->belongsToMany(User::class, 'checkup_patients', 'checkup_id', 'patient_id')
                ->withTimestamps();
}
// Checkup.php
public function checkupPatients()
{
    return $this->hasMany(CheckupPatient::class);
}

}
