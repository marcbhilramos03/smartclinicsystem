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
    return $this->belongsToMany(User::class, 'checkup_patients', 'checkup_id', 'patient_id')
                ->withPivot('id')   // include pivot id
                ->withTimestamps();
}

public function vitals() {
    return $this->hasMany(Vitals::class);
}

public function dentals() {
    return $this->hasMany(Dental::class);
}

}
