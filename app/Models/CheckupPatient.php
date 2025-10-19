<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'patient_id',
    ];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

 public function patient()
{
    return $this->belongsTo(User::class, 'patient_id', 'user_id'); // make sure 'user_id' is PK
}

}
