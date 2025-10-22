@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Assigned Checkups</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Checkup Type</th>
                <th>Notes</th>
                <th>Students</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkups as $checkup)
            <tr>
                <td>{{ $checkup->date }}</td>
                <td>{{ ucfirst($checkup->checkup_type) }}</td>
                <td>{{ $checkup->notes ?? '-' }}</td>
                <td>
                    <a href="{{ route('staff.checkups.students', $checkup->id) }}" class="btn btn-primary btn-sm">
                        View Students
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $checkups->links() }}
</div>
@endsection
