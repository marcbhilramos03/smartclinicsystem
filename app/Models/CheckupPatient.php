<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupPatient extends Model {
    protected $table = 'checkup_patients'; // Ensure table matches migration

    public function vitals() {
        return $this->hasMany(Vitals::class, 'checkup_patient_id');
    }

    public function dentals() {
        return $this->hasMany(Dental::class, 'checkup_patient_id');
    }

    public function patient() {
        return $this->belongsTo(User::class, 'patient_id', 'user_id');
    }

    public function checkup() {
        return $this->belongsTo(Checkup::class, 'checkup_id');
    }
}
