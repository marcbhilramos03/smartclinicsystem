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

    // Update stock or status of an inventory item
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:available,damaged,used,expired',
            'notes' => 'nullable|string',
        ]);

        // If the status is "used", "damaged", or "expired", archive the item
        if (in_array($validated['status'], ['used', 'damaged', 'expired'])) {
            ArchivedInventory::create([
                'inventory_id' => $inventory->id,
                'item_name' => $inventory->item_name,
                'type' => $inventory->type,
                'brand' => $inventory->brand,
                'unit' => $inventory->unit,
                'quantity' => $validated['stock_quantity'],
                'status' => $validated['status'],
                'archived_date' => Carbon::now(),
                'notes' => $validated['notes'],
            ]);

            // Remove or reset the inventory quantity
            $inventory->update([
                'stock_quantity' => 0,
                'status' => 'available',
            ]);

            return redirect()->route('admin.inventory.index')->with('success', 'Inventory archived successfully.');
        }

        // Otherwise, just update quantity/notes
        $inventory->update($validated);

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
