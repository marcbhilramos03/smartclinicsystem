@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Scheduled Checkups</h1>
    <a href="{{ route('admin.checkups.create') }}" class="btn btn-primary mb-3">Schedule Checkup</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Staff</th>
                <th>Date</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkups as $checkup)
            <tr>
                <td>{{ $checkup->patient->first_name }} {{ $checkup->patient->last_name }}</td>
                <td>{{ $checkup->staff->first_name }} {{ $checkup->staff->last_name }}</td>
                <td>{{ $checkup->date }}</td>
                <td>{{ $checkup->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $checkups->links() }}
</div>
@endsection
