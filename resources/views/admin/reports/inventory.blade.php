@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Inventory Report</h1>
    </div>

    <form method="GET" action="{{ route('admin.reports.inventory') }}" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <input type="month" name="month" class="form-control" 
                       value="{{ isset($month) && isset($year) ? sprintf('%04d-%02d', $year, $month) : \Carbon\Carbon::now()->format('Y-m') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Active Inventory for {{ $month ?? \Carbon\Carbon::now()->month }}/{{ $year ?? \Carbon\Carbon::now()->year }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Type</th>
                            <th>Brand</th>
                            <th>Unit</th>
                            <th>Stock Quantity</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventory as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ ucfirst($item->type) }}</td>
                            <td>{{ $item->brand }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->stock_quantity }}</td>
                            <td>{{ $item->expiry_date?->format('Y-m-d') }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No inventory records found for this month.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Active Inventory Stock Chart</h6>
        </div>
        <div class="card-body">
            <canvas id="inventoryChart"></canvas>
        </div>
    </div>

    @if($archived->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Archived Inventory for {{ $month ?? \Carbon\Carbon::now()->month }}/{{ $year ?? \Carbon\Carbon::now()->year }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Type</th>
                            <th>Brand</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Archived Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($archived as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ ucfirst($item->type) }}</td>
                            <td>{{ $item->brand }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>{{ $item->archived_date->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Archived Inventory Chart</h6>
        </div>
        <div class="card-body">
            <canvas id="archivedChart"></canvas>
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inventoryLabels = @json($inventory->pluck('item_name'));
    const inventoryData = @json($inventory->pluck('stock_quantity'));
    const ctx = document.getElementById('inventoryChart').getContext('2d');

    if (inventoryLabels.length > 0) {
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: inventoryLabels,
                datasets: [{
                    label: 'Stock Quantity',
                    data: inventoryData,
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#858796', '#fd7e14', '#6f42c1', '#20c997', '#17a2b8'
                    ],
                    borderWidth: 1
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    } else {
        ctx.font = '16px Arial';
        ctx.fillText('No active inventory for this month', 20, 50);
    }

    @if($archived->count() > 0)
    const archivedLabels = @json($archived->pluck('item_name'));
    const archivedData = @json($archived->pluck('quantity'));
    const archivedCtx = document.getElementById('archivedChart').getContext('2d');

    if (archivedLabels.length > 0) {
        new Chart(archivedCtx, {
            type: 'pie',
            data: {
                labels: archivedLabels,
                datasets: [{
                    label: 'Archived Quantity',
                    data: archivedData,
                    backgroundColor: [
                        '#e74a3b','#f6c23e','#858796','#fd7e14','#6f42c1'
                    ],
                    borderWidth: 1
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    } else {
        archivedCtx.font = '16px Arial';
        archivedCtx.fillText('No archived inventory for this month', 20, 50);
    }
    @endif
});
</script>
@endsection
