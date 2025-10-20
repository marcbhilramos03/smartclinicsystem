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

    /* Make table full width */
    .full-width-content table {
        width: 100%;
    }
</style>

<div class="full-width-content mb-4">
    <h1>Archived Inventory</h1>
        <li class="d-flex mb-3 gap-2">
            <a href="{{ route('admin.inventory.index') }}" class="btn btn-primary">Back</a>
        </li>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Original Item</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Archived Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($archivedItems as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ ucfirst($item->type) }}</td>
                        <td>{{ $item->brand ?? '-' }}</td>
                        <td>{{ $item->unit ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->archived_date)->format('Y-m-d') }}</td>
                        <td>{{ $item->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No archived items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $archivedItems->links() }}
        </div>
    </div>
</div>
@endsection
