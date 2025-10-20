@extends('layouts.app')

@section('content')
<style>
    /* Full width content */
    .full-width-content {
        width: 100%;
        max-width: 100%;
        margin-left: 0; /* align with sidebar */
        padding-left: 1rem;
        padding-right: 1rem;
    }

    /* Make tables full width */
    .full-width-content table {
        width: 100%;
    }

    /* Adjust tab button spacing */
    .full-width-content .nav-tabs .d-flex.gap-2 {
        margin-left: auto;
    }
</style>

<div class="full-width-content mb-4">
    <h1 class="mb-4">Inventory Management</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Toggle Tabs -->
    <ul class="nav nav-tabs mb-3" id="inventoryTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="medicine-tab" data-bs-toggle="tab" data-bs-target="#medicine" type="button" role="tab">
                💊 Medicines
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="apparatus-tab" data-bs-toggle="tab" data-bs-target="#apparatus" type="button" role="tab">
                ⚙️ Apparatus / Equipment
            </button>
        </li>
        <li class="d-flex mb-3 gap-2">
            <a href="{{ route('admin.inventory.archived') }}" class="btn btn-info text-black    ">View Archived</a>
        </li>
        <li class="d-flex mb-3 ml-2">
            <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">Add Item</a>
        </li>
    </ul>

    <div class="tab-content" id="inventoryTabsContent">
        <!-- MEDICINES TAB -->
        <div class="tab-pane fade show active" id="medicine" role="tabpanel">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Medicines</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Unit</th>
                                <th>Stock Quantity</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicines as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->brand ?? '-' }}</td>
                                <td>{{ $item->unit ?? '-' }}</td>
                                <td>{{ $item->stock_quantity }}</td>
                                <td>{{ $item->expiry_date ?? '-' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item->status == 'available') bg-success 
                                        @elseif($item->status == 'expired') bg-danger 
                                        @elseif($item->status == 'damaged') bg-warning 
                                        @else bg-secondary @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.inventory.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.inventory.destroy', $item) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">No medicines found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $medicines->links() }}
                </div>
            </div>
        </div>

        <!-- APPARATUS TAB -->
        <div class="tab-pane fade" id="apparatus" role="tabpanel">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Apparatus / Equipment</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Unit</th>
                                <th>Stock Quantity</th>
                                <th>Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($apparatus as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->brand ?? '-' }}</td>
                                <td>{{ $item->unit ?? '-' }}</td>
                                <td>{{ $item->stock_quantity }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item->status == 'available') bg-success 
                                        @elseif($item->status == 'damaged') bg-warning 
                                        @else bg-secondary @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.inventory.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.inventory.destroy', $item) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted">No apparatus found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $apparatus->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
