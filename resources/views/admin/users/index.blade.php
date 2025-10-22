@extends('layouts.app')

@section('page-title', 'Users Management')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Users Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add New User</a>

    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="patients-tab" data-bs-toggle="tab" href="#patients" role="tab">Patients</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="staff-tab" data-bs-toggle="tab" href="#staff" role="tab">Staff/Admin</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        {{-- Patients Tab --}}
        <div class="tab-pane fade show active" id="patients" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>School ID</th>
                        <th>Grade</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                        <tr>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ $patient->personalInformation->school_id ?? '' }}</td>
                            <td>{{ $patient->personalInformation->grade_level ?? '' }}</td>
                            <td>{{ $patient->phone_number }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $patient->user_id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.users.edit', $patient->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.users.destroy', $patient->user_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $patients->links() }}
        </div>

        {{-- Staff Tab --}}
        <div class="tab-pane fade" id="staff" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Profession</th>
                        <th>License</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $s)
                        <tr>
                            <td>{{ $s->first_name }} {{ $s->last_name }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ ucfirst($s->role) }}</td>
                            <td>{{ $s->credential->profession ?? '' }}</td>
                            <td>{{ $s->credential->license_type ?? '' }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $s->user_id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.users.edit', $s->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.users.destroy', $s->user_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $staff->links() }}
        </div>
    </div>
</div>
@endsection
