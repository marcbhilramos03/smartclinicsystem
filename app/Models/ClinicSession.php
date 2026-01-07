<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicSession extends Model
{
    use HasFactory;

    protected $table = 'clinic_sessions';
    protected $fillable = [
        'user_id',
        'admin_id',
        'session_date',
        'reason',
        'remedy',
    ];

    
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }
    
}
