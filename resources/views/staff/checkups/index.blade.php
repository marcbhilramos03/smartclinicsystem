@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Assigned Checkups</h2>

    @if($checkups->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Course / Grade</th>
                <th>Checkup Type</th>
                <th>Date</th>
                <th>Admin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkups as $checkup)
            <tr>
                <td>{{ $checkup->course->course ?? 'N/A' }}</td>
                <td>{{ ucfirst($checkup->checkup_type) }}</td>
                <td>{{ $checkup->date->format('F d, Y') }}</td>
                <td>{{ $checkup->admin->first_name ?? '' }} {{ $checkup->admin->last_name ?? '' }}</td>
                <td>
                    <a href="{{ route('staff.checkups.show', $checkup->id) }}" class="btn btn-primary btn-sm">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>No checkups assigned.</p>
    @endif
</div>
@endsection
