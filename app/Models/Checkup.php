<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_id',
        'date',
        'notes',
        'checkup_type',
    ];

    // The student who had the checkup
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // The staff who performed the checkup
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'user_id');
    }

    // One checkup has one vitals record
    public function vitals()
    {
        return $this->hasOne(Vitals::class, 'checkup_id', 'id');
    }

    // One checkup has one dental record
    public function dental()
    {
        return $this->hasOne(Dental::class, 'checkup_id', 'id');
    }
}
