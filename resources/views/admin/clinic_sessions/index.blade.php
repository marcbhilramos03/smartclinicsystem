@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Clinic Sessions</h2>
    <a href="{{ route('admin.clinic_sessions.create') }}" class="btn btn-primary mb-3">Add Session</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Remedy</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $session)
            <tr>
                <td>{{ $session->patient->first_name }} {{ $session->patient->last_name }}</td>
                <td>{{ $session->session_date }}</td>
                <td>{{ $session->reason }}</td>
                <td>{{ $session->remedy }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sessions->links() }}
</div>
@endsection
