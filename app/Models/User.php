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


    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id', 'user_id');
    }
    
    public function credential()
    {
        return $this->hasOne(Credential::class, 'staff_id', 'user_id');
    }

 
    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class, 'user_id', 'user_id');
    }

    public function clinicSessions()
    {
        return $this->hasMany(ClinicSession::class, 'user_id', 'user_id');
    }
public function checkupPatients()
{
    return $this->hasMany(CheckupPatient::class, 'patient_id', 'user_id');
}

public function checkups()
{
    return $this->belongsToMany(Checkup::class, 'checkup_patients', 'patient_id', 'checkup_id')
                ->withPivot('id') 
                ->withTimestamps();
}

public function vitals()
{
    return $this->hasManyThrough(
        Vitals::class,
        CheckupPatient::class,
        'patient_id',         
        'checkup_patient_id', 
        'user_id',             
        'id'                   
    );
}

public function dentals()
{
    return $this->hasManyThrough(
        Dental::class,
        CheckupPatient::class,
        'patient_id',          
        'checkup_patient_id',  
        'user_id',           
        'id'                   
    );
}
public function getFormattedDobAttribute() {
    return $this->date_of_birth ? \Carbon\Carbon::parse($this->date_of_birth)->format('F j, Y') : 'N/A';
}
public function latestClinicSession()
{
    return $this->hasOne(ClinicSession::class, 'user_id', 'user_id')
                ->latest('session_date');
}
public function getSchoolIdAttribute()
{
    return $this->personalInformation->school_id ?? null;
}


}
