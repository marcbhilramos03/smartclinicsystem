@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Archived Inventory</h1>

    <table class="table table-bordered">
        <thead>
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
            @foreach($archivedItems as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td>{{ ucfirst($item->type) }}</td>
                <td>{{ $item->brand ?? '-' }}</td>
                <td>{{ $item->unit ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->archived_date }}</td>
                <td>{{ $item->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $archivedItems->links() }}
</div>
@endsection
