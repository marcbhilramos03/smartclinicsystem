@extends('layouts.app')

@section('page-title', 'Students in ' . $course)

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>


    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">List of Students</h5>
        </div>
        <div class="card-body table-responsive">
            @if($patients->isEmpty())
                <p class="text-center text-muted">No students found for this course.</p>
            @else
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>School ID</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $index => $patient)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $patient->last_name }}, {{ $patient->first_name }}</td>
                                <td>{{ $patient->personalInformation->school_id ?? 'N/A' }}</td>
                                <td>{{ $patient->personalInformation->course ?? 'N/A' }}</td>
                                <td>{{ $patient->personalInformation->grade_level ?? 'N/A' }}</td>
                                <td>
                                            <a href="{{ route('admin.users.show', $patient->user_id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('admin.users.edit', $patient->user_id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $patient->user_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteUserModal" 
                                                data-user-id="{{ $patient->user_id }}" 
                                                data-user-name="{{ $patient->first_name }} {{ $patient->last_name }}"
                                            >
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            </form>
                                        </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteUserModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirm Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to deletet this user <strong id="deleteUserName"></strong>?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteUserForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
