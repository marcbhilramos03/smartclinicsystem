@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>All Checkups</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.checkups.create') }}" class="btn btn-primary mb-3">Create New Checkup</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Staff</th>
                <th>Course</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkups as $checkup)
            <tr>
                <td>{{ $checkup->date }}</td>
                <td>{{ $checkup->staff->first_name }} {{ $checkup->staff->last_name }}</td>
                <td>{{ $checkup->course->course }}</td>
                <td>{{ ucfirst($checkup->checkup_type) }}</td>
                <td>
                    <a href="{{ route('admin.checkups.show', $checkup->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('admin.checkups.edit', $checkup->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.checkups.destroy', $checkup->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this checkup?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
