@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Medical Histories</h2>
    <a href="{{ route('admin.medical_histories.create') }}" class="btn btn-primary mb-3">Add History</a>

    <div class="mb-3">
        <a href="{{ route('admin.medical_history.import_form') }}" class="btn btn-success">
            <i class="fas fa-upload"></i> Import Medical History
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Diagnosis</th>
                <th>Notes</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
            <tr>
                <td>{{ $history->patient->first_name }} {{ $history->patient->last_name }}</td>
                <td>{{ $history->diagnosis }}</td>
                <td>{{ $history->notes }}</td>
                <td>{{ $history->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $histories->links() }}
</div>
@endsection
