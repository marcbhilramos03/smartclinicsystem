<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    protected $table = 'personal_information';

    protected $fillable = [
        'user_id',
        'school_id',
        'gender',
        'birthdate',
        'contact_number',
        'address',
        'department',
        'year_level',
    ];
    // protected $primaryKey = 'user_id';

    /**
     * Get the user that owns the personal information.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
  public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class, 'personal_information_id', 'id');
    }
}
