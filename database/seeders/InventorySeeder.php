<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory; // Make sure your Inventory model exists

class InventorySeeder extends Seeder
{
    public function run()
    {
        Inventory::insert([
            [
                'item_name' => 'Paracetamol',
                'type' => 'medicine',
                'brand' => 'MediCare',
                'unit' => 'tablet',
                'stock_quantity' => 100,
                'expiry_date' => '2026-05-01',
                'status' => 'available',
                'notes' => 'Used for fever and pain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Syringe 5ml',
                'type' => 'apparatus',
                'brand' => 'HealthEquip',
                'unit' => 'piece',
                'stock_quantity' => 50,
                'expiry_date' => null,
                'status' => 'available',
                'notes' => 'Disposable syringes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Bandages',
                'type' => 'apparatus',
                'brand' => 'FirstAidCo',
                'unit' => 'roll',
                'stock_quantity' => 30,
                'expiry_date' => null,
                'status' => 'available',
                'notes' => 'For wound dressing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
