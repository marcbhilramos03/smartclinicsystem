@extends('layouts.app')

@section('title', 'Inventory Dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-4  fw-bold">Inventory Dashboard</h2>

    {{-- Toggle Tabs --}}
    <ul class="nav nav-tabs mb-4" id="inventoryTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="equipment-tab" data-bs-toggle="tab" data-bs-target="#equipment" type="button" role="tab" aria-controls="equipment" aria-selected="true">
                Equipment
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="medicine-tab" data-bs-toggle="tab" data-bs-target="#medicine" type="button" role="tab" aria-controls="medicine" aria-selected="false">
                Medicine
            </button>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content" id="inventoryTabsContent">
        {{-- Equipment Tab --}}
        <div class="tab-pane fade show active" id="equipment" role="tabpanel" aria-labelledby="equipment-tab">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    Equipment Inventory
                </div>
                <div class="card-body p-0">
                    @if($equipmentItems->isEmpty())
                        <div class="alert alert-info m-3 text-center">No equipment available.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Condition</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipmentItems as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->condition ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Medicine Tab --}}
        <div class="tab-pane fade" id="medicine" role="tabpanel" aria-labelledby="medicine-tab">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white fw-bold">
                    Medicine Inventory
                </div>
                <div class="card-body p-0">
                    @if($medicineItems->isEmpty())
                        <div class="alert alert-info m-3 text-center">No medicines available.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Expiry Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicineItems as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->expiration_date ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Optional: small CSS tweaks for hover effect --}}
<style>
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

@endsection
