<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone_number',
        'address',
        'role',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // Personal Information
    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id', 'user_id');
    }

    // Admin tables
    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class, 'user_id', 'user_id');
    }

    public function clinicSessions()
    {
        return $this->hasMany(ClinicSession::class, 'user_id', 'user_id');
    }

    // Staff tables (via checkups)
    public function checkups()
    {
        return $this->hasManyThrough(
            Checkup::class,
            PersonalInformation::class,
            'user_id',               // FK on personal_information
            'personal_information_id', // FK on checkups
            'user_id',               // Local key on users
            'id'                     // Local key on personal_information
        );
    }

    public function vitals()
    {
        return $this->hasManyThrough(
            Vitals::class,
            Checkup::class,
            'personal_information_id', // FK on checkups
            'checkup_id',              // FK on vitals
            'user_id',                 // Local key on users
            'id'                       // Local key on checkups
        );
    }

    public function dentals()
    {
        return $this->hasManyThrough(
            Dental::class,
            Checkup::class,
            'personal_information_id', // FK on checkups
            'checkup_id',              // FK on dentals
            'user_id',                 // Local key on users
            'id'                       // Local key on checkups
        );
    }
}
