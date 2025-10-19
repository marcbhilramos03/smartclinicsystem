<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'profession',
        'license_type',
        'specialization',
        'role',
        'email',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    /* -------------------- Role Helpers -------------------- */

    public function isAdmin()  { return $this->role === 'admin'; } // Nurse
    public function isStaff()  { return $this->role === 'staff'; } // Checkup staff
    public function isPatient(){ return $this->role === 'patient'; }

    /* -------------------- Relationships -------------------- */

    // 🧍 Patient relationships
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'user_id', 'user_id');
    }

    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class, 'user_id', 'user_id');
    }

    public function clinicSessions()
    {
        return $this->hasMany(ClinicSession::class, 'user_id', 'user_id');
    }

    // 🩺 Admin (nurse) handles clinic sessions & medical histories
    public function handledClinicSessions()
    {
        return $this->hasMany(ClinicSession::class, 'admin_id', 'user_id');
    }

    public function handledHistories()
    {
        return $this->hasMany(MedicalHistory::class, 'admin_id', 'user_id');
    }

    public function performedCheckups()
    {
        return $this->hasMany(Checkup::class, 'staff_id', 'user_id');
    }

    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id', 'user_id');
    }
    public function checkups()
{
    return $this->belongsToMany(Checkup::class, 'checkup_patients', 'patient_id', 'checkup_id')
                ->withTimestamps();
}

}
