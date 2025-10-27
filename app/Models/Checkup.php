<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkup extends Model {
protected $fillable = [
    'admin_id',
    'staff_id',
    'checkup_type',
    'date',
    'notes',
    'personal_information_id', // add this!
];

    public function staff() {
        return $this->belongsTo(User::class, 'staff_id', 'user_id');
    }

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }

    
public function patients() {
    return $this->belongsToMany(User::class, 'checkup_patients', 'checkup_id', 'patient_id');
}

public function vitals() {
    return $this->hasMany(Vitals::class, 'checkup_id');
}

public function dentals() {
    return $this->hasMany(Dental::class, 'checkup_id');
}
public function checkupPatients()
{
    return $this->hasMany(CheckupPatient::class, 'checkup_id');
}

}
