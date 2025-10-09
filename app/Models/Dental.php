<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dental extends Model
{
    use HasFactory;

    protected $table = 'dental';
    
    protected $fillable = [
        'checkup_id',
        'dental_status',
        'notes',
    ];

    // Each dental record belongs to a checkup
    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id', 'id');
    }
}
