<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $table = 'medical_histories';

    protected $fillable = [
        'user_id',
        'history_type',    // allergy, illness, vaccination
        'description',
        'date_recorded',
        'admin_id',        // who recorded this
    ];

    /**
     * The patient (user) this medical history belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function admin()
    {
    return $this->belongsTo(User::class, 'admin_id'); // foreign key is admin_id
    }
    /**
     * The medical record this history is associated with.
     */
}
