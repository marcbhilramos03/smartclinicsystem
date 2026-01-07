<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupPatient extends Model
{
    protected $table = 'checkup_patients';

    protected $fillable = [
        'checkup_id',
        'patient_id',
        'status',
    ];

    
    public function vitals()
{
    return $this->hasOne(Vitals::class, 'checkup_patient_id');
}

public function dentals()
{
    return $this->hasOne(Dental::class, 'checkup_patient_id');
}


    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'user_id');
    }

    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id');
    }

    public function markAsCompleted()
    {
        $this->status = 'done';
        $this->save();
    }

    public function markAsPending()
    {
        $this->status = 'pending';
        $this->save();
    }
}
