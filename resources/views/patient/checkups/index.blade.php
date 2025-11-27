@extends('layouts.app')

@section('content')
<div class="container my-5">
    @if($checkups->count())
        <div class="row g-4">
            @foreach($checkups as $checkup)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm hover-card">
                    <div class="card-header fw-bold text-center" style="background-color:#003366; color:#fff;">
                        {{ \Carbon\Carbon::parse($checkup->date)->format('M d, Y') }}
                    </div>
                    <div class="card-body text-center">
                        <p><i class="bi bi-file-medical me-2"></i><strong>Type:</strong> {{ ucfirst($checkup->checkup_type) }}</p>
                        <p><i class="bi bi-person-circle me-2"></i><strong>Doctor:</strong> {{ $checkup->staff->first_name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $checkups->links() }}
        </div>
    @else
        <div class="alert alert-info text-center fs-5">
            You have no checkups yet.
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #e6f0ff; /* light blue background */
    }
    .hover-card:hover {
        transform: translateY(-8px);
        transition: all 0.3s ease;
        box-shadow: 0 0.8rem 1.5rem rgba(0,0,0,0.25) !important;
    }
    .card-body p {
        font-size: 1.1rem;
    }
    .card-body i {
        font-size: 1.3rem;
    }
    h2 {
        font-size: 2.2rem;
    }
    .btn-outline-secondary {
        font-size: 1rem;
    }
</style>
@endpush
