@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Inventory Item</h1>

    <form action="{{ route('admin.inventory.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Type</label>
            <select name="type" id="itemType" class="form-control" required>
                <option value="medicine">Medicine</option>
                <option value="apparatus">Apparatus</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Item Name</label>
            <input type="text" name="item_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Brand</label>
            <input type="text" name="brand" class="form-control">
        </div>

        <div class="mb-3">
            <label>Unit</label>
            <input type="text" name="unit" class="form-control">
        </div>

        <div class="mb-3">
            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" min="0" required>
        </div>

        <!-- Expiry Date (Hidden for apparatus) -->
        <div class="mb-3" id="expiryField">
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="available">Available</option>
                <option value="used">Used</option>
                <option value="damaged">Damaged</option>
                <option value="expired">Expired</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
</div>

{{-- JavaScript to toggle Expiry Date --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const itemType = document.getElementById("itemType");
        const expiryField = document.getElementById("expiryField");

        function toggleExpiry() {
            if (itemType.value === "apparatus") {
                expiryField.style.display = "none";
                expiryField.querySelector("input").value = "";
            } else {
                expiryField.style.display = "block";
            }
        }

        // Run on page load
        toggleExpiry();

        // Run on change
        itemType.addEventListener("change", toggleExpiry);
    });
</script>
@endsection
