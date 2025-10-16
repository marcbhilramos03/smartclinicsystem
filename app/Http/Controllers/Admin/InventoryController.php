<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ArchivedInventory;
use Carbon\Carbon;

class InventoryController extends Controller
{
    // List all inventory items
    public function index()
    {
        $medicines = Inventory::where('type', 'medicine')->paginate(10, ['*'], 'medicines');
        $apparatus = Inventory::where('type', 'apparatus')->paginate(10, ['*'], 'apparatus');

        return view('admin.inventory.index', compact('medicines', 'apparatus'));
    }

    // Show form to add a new inventory item
    public function create()
    {
        return view('admin.inventory.create');
    }

    // Store a new inventory item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'required|in:medicine,apparatus',
            'brand' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'status' => 'required|in:available,damaged,used,expired',
            'notes' => 'nullable|string',
        ]);

        Inventory::create($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory item added successfully.');
    }

    // Show form to edit an item
    public function edit(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }
public function update(Request $request, Inventory $inventory)
{
    $validated = $request->validate([
        'adjustment_type' => 'required|in:add,subtract',
        'quantity_change' => 'required|integer|min:0',
        'status' => 'required|in:available,damaged,used,expired',
        'notes' => 'nullable|string',
    ]);

    // Calculate new stock
    $quantityChange = $validated['quantity_change'];
    if ($validated['adjustment_type'] == 'subtract') {
        $quantityChange = -$quantityChange;
    }

    $newQuantity = max(0, $inventory->stock_quantity + $quantityChange);

    // Archive if needed
    if (in_array($validated['status'], ['used', 'damaged', 'expired'])) {
        ArchivedInventory::create([
            'inventory_id' => $inventory->id,
            'item_name' => $inventory->item_name,
            'type' => $inventory->type,
            'brand' => $inventory->brand,
            'unit' => $inventory->unit,
            'quantity' => abs($quantityChange),
            'status' => $validated['status'],
            'archived_date' => Carbon::now(),
            'notes' => $validated['notes'],
        ]);

        $inventory->stock_quantity = max(0, $inventory->stock_quantity - abs($quantityChange));
        $inventory->status = 'available';
        $inventory->notes = $validated['notes'];
        $inventory->save();

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory archived successfully.');
    }

    // Otherwise, update normally
    $inventory->update([
        'stock_quantity' => $newQuantity,
        'status' => $validated['status'],
        'notes' => $validated['notes'],
    ]);

    return redirect()->route('admin.inventory.index')->with('success', 'Inventory updated successfully.');
}

    // Delete an inventory item
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Inventory item deleted.');
    }

    // Optional: View archived items
    public function archived()
    {
        $archivedItems = ArchivedInventory::with('inventory')->paginate(10);
        return view('admin.inventory.archived', compact('archivedItems'));
    }
}
