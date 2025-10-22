<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $table = 'credential';
    protected $primaryKey = 'cred_id';

    protected $fillable = [
        'staff_id',
        'profession',
        'license_type',
        'specialization'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id', 'user_id');
    }
}
