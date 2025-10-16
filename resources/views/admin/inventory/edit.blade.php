@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Inventory Item</h1>

    <form action="{{ route('admin.inventory.update', $inventory) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Current stock display -->
        <div class="mb-3">
            <label>Current Stock Quantity</label>
            <input type="number" class="form-control" value="{{ $inventory->stock_quantity }}" disabled>
        </div>

        <!-- Quantity adjustment -->
        <div class="mb-3">
            <label>Quantity Adjustment</label>
            <div class="input-group">
                <select name="adjustment_type" class="form-control" required>
                    <option value="add">Add</option>
                    <option value="subtract">Subtract</option>
                </select>
                <input type="number" name="quantity_change" class="form-control" value="0" min="0" required>
            </div>
            <small class="form-text text-muted">
                Select "Add" to increase stock or "Subtract" to decrease stock, then enter the amount.
            </small>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="available" {{ $inventory->status=='available'?'selected':'' }}>Available</option>
                <option value="used" {{ $inventory->status=='used'?'selected':'' }}>Used</option>
                <option value="damaged" {{ $inventory->status=='damaged'?'selected':'' }}>Damaged</option>
                <option value="expired" {{ $inventory->status=='expired'?'selected':'' }}>Expired</option>
            </select>
        </div>

        <!-- Notes -->
        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ $inventory->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
