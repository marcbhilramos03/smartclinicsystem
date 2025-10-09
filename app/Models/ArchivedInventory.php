<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedInventory extends Model
{
    use HasFactory;

    protected $table = 'archived_inventory';

    protected $fillable = [
        'inventory_id',
        'item_name',
        'type',
        'brand',
        'unit',
        'quantity',
        'status',
        'archived_date',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'archived_date' => 'date',
    ];

    /**
     * The original inventory item
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}
