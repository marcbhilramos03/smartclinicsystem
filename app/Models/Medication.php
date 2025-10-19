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
        'stock_quantity'
    ];

    /**
     * Clinic session this medication belongs to
     */
    public function clinicSession()
    {
        return $this->belongsTo(ClinicSession::class, 'session_id', 'id');
    }

    /**
     * Inventory item prescribed
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Automatically deduct stock and archive usage when medication is created
     */
    protected static function booted()
    {
        static::created(function ($medication) {
            if ($medication->inventory_id) {
                $inventory = Inventory::find($medication->inventory_id);
                if ($inventory && $inventory->stock_quantity >= $medication->stock_quantity) {
                    $inventory->decrement('quantity', $medication->stock_quantity);

                    // Archive used units (assuming your Inventory has an archive method)
                    if (method_exists($inventory, 'archive')) {
                        $inventory->archive(
                            $medication->quantity,
                            'used',
                            'Prescribed in clinic session ID: ' . $medication->session_id
                        );
                    }
                }
            }
        });
    }
}
