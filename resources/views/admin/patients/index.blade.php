@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Patients</h2>

    <form action="{{ route('admin.patients.index') }}" method="GET" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search patients..." class="form-control">
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                <td>{{ $patient->phone_number }}</td>
                <td>
                    <a href="{{ route('admin.patients.show', $patient->user_id) }}" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $patients->links() }}
</div>
@endsection
