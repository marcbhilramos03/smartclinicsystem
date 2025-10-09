<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';
    protected $fillable = [
        'item_name',
        'type',
        'brand',
        'unit',
        'stock_quantity',
        'expiry_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'expiry_date' => 'date',
    ];

    /**
     * Archived records of this inventory item
     */
    public function archived()
    {
        return $this->hasMany(ArchivedInventory::class, 'inventory_id', 'id');
    }

    /**
     * Check if the inventory item is usable
     */
    public function isUsable(): bool
    {
        return $this->status === 'available' && $this->stock_quantity > 0;
    }

    /**
     * Archive a quantity of this inventory item
     */
    public function archive(int $quantity, string $status, ?string $notes = null)
    {
        // Create archive record
        $archive = $this->archived()->create([
            'item_name' => $this->item_name,
            'type' => $this->type,
            'brand' => $this->brand,
            'unit' => $this->unit,
            'quantity' => $quantity,
            'status' => $status,
            'archived_date' => now(),
            'notes' => $notes
        ]);

        // Deduct from stock
        $this->stock_quantity -= $quantity;
        if ($this->stock_quantity <= 0) {
            $this->status = $status; // mark as used/expired/damaged
        }
        $this->save();

        return $archive;
    }
}
