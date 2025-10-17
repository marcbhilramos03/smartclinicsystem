<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'inventory_id',
        'dosage',
        'duration',
        'quantity'
    ];

    /**
     * The clinic session this medication belongs to
     */
    public function clinicSession()
    {
        return $this->belongsTo(ClinicSession::class, 'session_id', 'id');
    }

    /**
     * The inventory item prescribed
     */
   public function inventory() {
    return $this->belongsTo(Inventory::class);
}


    /**
     * Override create method to deduct stock and archive used units
     */
    public static function booted()
    {
        static::created(function ($medication) {
            $inventory = Inventory::find($medication->inventory_id);

            if ($inventory && $inventory->isUsable()) {
                $inventory->archive($medication->quantity, 'used', 'Prescribed in clinic session ID: '.$medication->session_id);
            }
        });
    }
}
