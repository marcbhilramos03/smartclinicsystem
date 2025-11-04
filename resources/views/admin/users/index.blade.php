@extends('layouts.app')

@section('page-title', 'Users Management')

@section('content')
<style>
    /* Course Card Styles */
    .course-card {
        color: #fff;
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

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .course-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .course-students {
        font-size: 1rem;
        margin-bottom: 15px;
    }

    .course-btn {
        background: rgba(255, 255, 255, 0.9);
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
</style>

@php
    // Define a color palette
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

    // Function to get a consistent color for each course
    function getCourseColor($courseName, $colors) {
        $index = abs(crc32($courseName)) % count($colors);
        return $colors[$index];
    }
@endphp

<div class="container-fluid py-4">
    <h2 class="mb-4 text-dark">Users Management</h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ADD USER BUTTON --}}
    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>

    {{-- NAV TABS --}}
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

    {{-- TAB CONTENT --}}
    <div class="tab-content mt-4" id="userTabsContent">

        {{-- PATIENTS TAB --}}
        <div class="tab-pane fade show active" id="patients" role="tabpanel" aria-labelledby="patients-tab">
            <h4 class="mb-4 text-dark">Courses</h4>
            <div class="row">
                @forelse ($courses as $course)
                    @php
                        $bgColor = getCourseColor($course->course ?? 'No Course', $colors);
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

        {{-- STAFF TAB --}}
        <div class="tab-pane fade" id="staff" role="tabpanel" aria-labelledby="staff-tab">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-3 text-dark">Staff and Admin Users</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Profession</th>
                                    <th>License</th>
                                    <th>Actions</th>
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
                                            <form action="{{ route('admin.users.destroy', $s->user_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
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
@endsection
