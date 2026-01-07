@extends('layouts.app')

@section('page-title', 'Users Management')

@section('content')
<style>
    .course-card {
        color: #080808;
        text-shadow: 1px 1px 2px rgb(255, 255, 255);
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
        padding: 25px 15px;
        min-height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .course-title {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #fff;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    .course-students {
        font-size: 1rem;
        margin-bottom: 15px;
        background: rgba(255, 255, 255, 0.9);
        color: #333;
        font-weight: 600;
        border-radius: 5px;
        padding: 3px 8px;
    }

    .course-btn {
        background: rgba(108, 207, 237, 0.9);
        color: #333;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .course-btn:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
    }

    h2 {
        color: black;
    }
</style>

@php
$colors = [
    'linear-gradient(135deg, #6a11cb, #2575fc)',
    'linear-gradient(135deg, #ff416c, #ff4b2b)',
    'linear-gradient(135deg, #11998e, #38ef7d)',
    'linear-gradient(135deg, #f7971e, #ffd200)',
    'linear-gradient(135deg, #e44d26, #f16529)',
    'linear-gradient(135deg, #0f2027, #203a43, #2c5364)',
    'linear-gradient(135deg, #ff7e5f, #feb47b)',
    'linear-gradient(135deg, #43cea2, #185a9d)'
];

$formIndex = 0;
function getFormColor($colors, &$formIndex) {
    $color = $colors[$formIndex % count($colors)];
    $formIndex++;
    return $color;
}
@endphp

<div class="container-fluid py-4">
    <h2 class="mb-4">Users Management</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>

    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="patients-tab" data-bs-toggle="tab" data-bs-target="#patients" type="button" role="tab">
                Students
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staff" type="button" role="tab">
                Doctors/Nurses
            </button>
        </li>
    </ul>

    <div class="tab-content mt-4" id="userTabsContent">

        <div class="tab-pane fade show active" id="patients" role="tabpanel" aria-labelledby="patients-tab">
            <h4 class="mb-4 text-dark">Courses</h4>
            <div class="row">
                @forelse ($courses as $course)
                    @php
                        $bgColor = getFormColor($colors, $formIndex);
                    @endphp
                    <div class="col-md-4 mb-4">
                        <div class="course-card" style="background: {{ $bgColor }}">
                            <h4 class="course-title">{{ $course->course ?? 'No Course Listed' }}</h4>
                            <p class="course-students">Total Students: {{ $course->total_students }}</p>
                            <a href="{{ route('admin.users.by_course', $course->course) }}" class="course-btn">
                                View Students
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No courses found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="staff" role="tabpanel" aria-labelledby="staff-tab">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-3 text-dark">Doctors and Nurses</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Profession</th>
                                    <th scope="col">License</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staff as $s)
                                    <tr>
                                        <td>{{ $s->first_name }} {{ $s->last_name }}</td>
                                        <td>{{ $s->email }}</td>
                                        <td>{{ $s->credential->profession ?? '—' }}</td>
                                        <td>{{ $s->credential->license_type ?? '—' }}</td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('admin.users.show', $s->user_id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('admin.users.edit', $s->user_id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteUserModal" 
                                                data-user-id="{{ $s->user_id }}" 
                                                data-user-name="{{ $s->first_name }} {{ $s->last_name }}"
                                            >
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No staff or admin found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $staff->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteUserModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirm Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this user<strong id="deleteUserName"></strong>?</p>
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

@push('scripts')
<script>
var deleteUserModal = document.getElementById('deleteUserModal');
deleteUserModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-user-id');
    var userName = button.getAttribute('data-user-name');

    var userNameSpan = deleteUserModal.querySelector('#deleteUserName');
    userNameSpan.textContent = userName;

    var form = deleteUserModal.querySelector('#deleteUserForm');
    form.action = '/admin/users/' + userId;
});
</script>
@endpush

@endsection
