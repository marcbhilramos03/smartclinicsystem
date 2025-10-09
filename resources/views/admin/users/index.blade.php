@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Users</h1>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add New User</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Credential</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>

                <td>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</td>
                <td>
                    {{ $user->email }}
                    @if($user->personalInformation && $user->personalInformation->school_id)
                        {{ $user->personalInformation->school_id }}
                    @endif
                </td>                
                <td><span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span></td>
                <td>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
