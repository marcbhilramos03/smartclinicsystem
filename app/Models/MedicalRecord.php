<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'staff_id',
        'admin_id',
        'checkup_id',
        'vitals_id',
        'dentals_id',
        'recordable_id',
        'recordable_type',
    ];

    public function recordable()
    {
        return $this->morphTo();
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
