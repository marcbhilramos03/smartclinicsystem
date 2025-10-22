<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'email', 'password',
        'gender', 'address', 'phone_number', 'date_of_birth', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function credential()
    {
        // one user (staff) has one credential record
        return $this->hasOne(Credential::class, 'staff_id', 'user_id');
    }
     public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id', 'user_id');
    }

    /**
     * Clinic Sessions
     */
    public function clinicSessions()
    {
        return $this->hasMany(ClinicSession::class, 'user_id', 'user_id');
    }

    /**
     * Medical Histories
     */
    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class, 'user_id', 'user_id');
    }

    /**
     * Checkups (through checkup patients)
     */
public function patients()
{
    return $this->belongsToMany(
        User::class,           // Related model
        'checkup_patients',     // Pivot table
        'checkup_id',          // Foreign key on pivot table pointing to this model (Checkup)
        'patient_id'           // Foreign key on pivot table pointing to related model (User)
    )->withTimestamps();
}


    // In User.php (Patient)
public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class, 'patient_id', 'user_id'); // or 'user_id' if that's PK
}


}
