@extends('layouts.app')

@section('page-title', 'User Details')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"
                        style="color:#000;"
>User Details</h2>
        @php
    if($user->role === 'patient') {
        $backUrl = route('admin.users.by_course', $user->personalInformation->course ?? '');
    } else {
        $backUrl = route('admin.users.index'); 
    }
@endphp

<a href="{{ $backUrl }}" class="btn btn-secondary" style="color:#000;">
    <i class="fas fa-arrow-left me-1" style="color:#000;"></i> Back
</a>

    </div>

    <div class="mb-4">
        @if($user->role === 'admin')
            <span class="badge bg-dark fs-6">Administrator</span>
        @elseif($user->role === 'staff')
            <span class="badge bg-info text-dark fs-6">Staff</span>
        @else
            <span class="badge bg-success fs-6"
                            style="color:#000;"
>Student</span>
        @endif
    </div>
<div class="card user-card mb-4 shadow-sm border-0 rounded-3">
    <div class="card-header bg-primary text-white fw-bold d-flex align-items-center">
        <i class="fas fa-user me-2"></i> Basic Information
    </div>
    <div class="card-body text-dark">
        <div class="row g-3">
            @php
                $basicInfo = [
                    ['label' => 'Name', 'icon' => 'fas fa-id-card', 'value' => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name],
                    ['label' => 'Email', 'icon' => 'fas fa-envelope', 'value' => $user->email ?? 'N/A', 'condition' => $user->role !== 'patient'],
                    ['label' => 'Gender', 'icon' => 'fas fa-venus-mars', 'value' => $user->gender ?? 'N/A'],
                    [ 'label' => 'Date of Birth', 'icon' => 'fas fa-calendar-alt', 'value' => $user->formatted_dob],
                    ['label' => 'Contact', 'icon' => 'fas fa-phone', 'value' => $user->phone_number ?? 'N/A'],
                    ['label' => 'Address', 'icon' => 'fas fa-map-marker-alt', 'value' => $user->address ?? 'N/A', 'full' => true],
                ];
            @endphp

           @foreach($basicInfo as $info)
    @if(!isset($info['condition']) || $info['condition'])
        @php
            $colClass = isset($info['full']) && $info['full'] 
                        ? 'col-12' 
                        : ($user->role === 'patient' ? 'col-6 col-md-5' : 'col-6 col-md-4');
        @endphp

        <div class="{{ $colClass }}">
            <div class="info-box p-2 shadow-sm rounded-3 h-100">
                <p class="label"><i class="{{ $info['icon'] }} me-1"></i> {{ $info['label'] }}</p>
                <p class="value">{{ $info['value'] }}</p>
            </div>
        </div>
    @endif
@endforeach

        </div>
    </div>
</div>


    @if($user->role === 'patient')
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="fas fa-school me-2"></i> School Information
                </div>
                <div class="card-body text-black">
                    <p class="mb-2"><strong>School ID:</strong> {{ $user->personalInformation->school_id ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Course:</strong> {{ $user->personalInformation->course ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Grade Level:</strong> {{ $user->personalInformation->grade_level ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-warning text-white fw-bold">
                    <i class="fas fa-phone-alt me-2"></i> Emergency Contact
                </div>
                <div class="card-body text-black">
                    <p class="mb-2"><strong>Name:</strong> {{ $user->personalInformation->emer_con_name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Relationship:</strong> {{ $user->personalInformation->emer_con_rel ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Phone:</strong> {{ $user->personalInformation->emer_con_phone ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Address:</strong> {{ $user->personalInformation->emer_con_address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($user->role === 'staff' || $user->role === 'admin')
    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-header bg-info text-white fw-bold">
            <i class="fas fa-id-card me-2"></i> Credentials
        </div>
        <div class="card-body row g-3 text-black">
            <div class="col-md-4"><strong>Profession:</strong> {{ $user->credential->profession ?? 'N/A' }}</div>
            <div class="col-md-4"><strong>License Type:</strong> {{ $user->credential->license_type ?? 'N/A' }}</div>
            <div class="col-md-4"><strong>Specialization:</strong> {{ $user->credential->specialization ?? 'N/A' }}</div>
        </div>
    </div>
    @endif

</div>

<style>
    .card-body p, .card-body div {
        color: #000 !important; 
    }
    .card-header i {
        color: rgba(255,255,255,0.9);
    }
    .badge {
        padding: 0.5em 0.8em;
    }
.user-card {
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background: #fff;
}


.user-card .card-header {
    font-size: 1.2rem;
    letter-spacing: 0.5px;
    background: linear-gradient(90deg, #0062cc, #0056b3);
}

.user-card .label {
    font-weight: 600;
    font-size: 0.9rem;
    color: #495057;
    margin-bottom: 2px;
    display: flex;
    align-items: center;
}

.user-card .value {
    font-size: 1rem;
    color: #212529;
    margin-bottom: 8px;
    word-wrap: break-word;
    padding-left: 5px;
}

@media (max-width: 576px) {
    .user-card .label {
        font-size: 0.85rem;
    }
    .user-card .value {
        font-size: 0.95rem;
    }
}
</style>
@endsection
