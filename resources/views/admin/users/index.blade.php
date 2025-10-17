@extends('layouts.app')

@section('content')
<style>
    /* Make content full width */
    .full-width-content {
        width: 100%;
        max-width: 100%;
        margin-left: 0; /* align with sidebar */
        padding-left: 1rem;
        padding-right: 1rem;
    }

    /* Optional: make tables stretch full width */
    .full-width-content table {
        width: 100%;
    }
</style>

<div class="full-width-content mb-4 d-flex flex-column">
    <h1 class="mb-4">Manage Users</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="userTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staff" type="button" role="tab" aria-controls="staff" aria-selected="true">
                🧑‍💼 Doctors/Nurses
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="patients-tab" data-bs-toggle="tab" data-bs-target="#patients" type="button" role="tab">
                🧑‍🎓 Students
            </button>
        </li>

        <li class="d-flex mb-3 gap-2 ms-auto">
            <a href="{{ route('admin.patients.import-form') }}" class="btn btn-secondary">Upload Students</a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add Doctor/Nurse</a>
        </li>
    </ul>

    <div class="tab-content" id="userTabsContent">
<!-- PATIENTS TAB -->
<div class="tab-pane fade" id="patients" role="tabpanel">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Students</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>School ID</th>
                        <th>Name</th>
                        <th>Grade Level</th>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $user)
                        @php
                            $personal = $user->personalInformation;
                            $course = $personal?->courseInformation;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration + ($patients->currentPage() - 1) * $patients->perPage() }}</td>
                            <td>{{ $personal->school_id ?? '-' }}</td>
                            <td>
                                {{ $user->first_name }}
                                {{ $user->middle_name ? $user->middle_name.' ' : '' }}
                                {{ $user->last_name }}
                            </td>
                            <td>{{ $course->grade_level ?? '-' }}</td>
                            <td>{{ $course->course ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button"
                                    class="btn btn-sm btn-danger deleteBtn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-name="{{ $user->first_name }}"
                                    data-route="{{ route('admin.users.destroy', $user) }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $patients->links() }}</div>
    </div>
</div>

        <!-- STAFF / ADMINS TAB -->
        <div class="tab-pane fade show active" id="staff" role="tabpanel">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Doctors/Nurses</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staff as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($staff->currentPage()-1)*$staff->perPage() }}</td>
                                <td>{{ $user->first_name }} {{ $user->middle_name ? $user->middle_name.' ' : '' }}{{ $user->last_name }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info text-white">View</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-name="{{ $user->first_name }}"
                                        data-route="{{ route('admin.users.destroy', $user) }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">No staff/admins found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">{{ $staff->links() }}</div>
            </div>
        </div>

    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header justify-content-center border-0">
          <h5 class="modal-title">Confirm Delete</h5>
          <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <strong id="deleteUserName"></strong>?
        </div>
        <div class="modal-footer justify-content-center border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteUserName = document.getElementById('deleteUserName');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const name = button.getAttribute('data-name');
        const route = button.getAttribute('data-route');

        deleteUserName.textContent = name;
        deleteForm.action = route;
    });
});
</script>
@endsection
