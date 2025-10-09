<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
        public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id', 'user_id');
    }
    public function isAdmin() {
    return $this->role === 'admin';
    }

    public function isStaff() {
        return $this->role === 'staff';
    }

    public function isPatient() {
        return $this->role === 'patient';
    }
    public function checkups()
    {
        return $this->hasMany(Checkup::class, 'user_id', 'user_id');
    }
    public function performedCheckups()
    {
        return $this->hasMany(Checkup::class, 'staff_id', 'user_id');
    }
    public function medicalHistories()
    {
    return $this->hasMany(MedicalHistory::class, 'user_id', 'user_id');
    }
       public function clinicSessions()
    {
        return $this->hasMany(ClinicSession::class, 'user_id', 'user_id');
    }

}
