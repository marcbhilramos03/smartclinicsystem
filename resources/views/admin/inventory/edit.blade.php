@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Inventory Item</h1>

    <form action="{{ route('admin.inventory.update', $inventory) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" min="0" value="{{ $inventory->stock_quantity }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="available" {{ $inventory->status=='available'?'selected':'' }}>Available</option>
                <option value="used" {{ $inventory->status=='used'?'selected':'' }}>Used</option>
                <option value="damaged" {{ $inventory->status=='damaged'?'selected':'' }}>Damaged</option>
                <option value="expired" {{ $inventory->status=='expired'?'selected':'' }}>Expired</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ $inventory->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
