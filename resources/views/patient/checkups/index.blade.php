<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Checkups</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f0ff; /* light blue background */
        }
        .hover-card:hover {
            transform: translateY(-8px);
            transition: all 0.3s ease;
            box-shadow: 0 0.8rem 1.5rem rgba(0,0,0,0.25) !important;
        }
        .card-header {
            background-color: #003366 !important; /* dark blue shade */
            color: #fff !important;
            font-size: 1.25rem;
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
</head>
<body>

<div class="container my-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold text-dark">My Checkups</h2>
        <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-secondary">&larr; Back to Dashboard</a>
    </div>

    @if($checkups->count())
        <div class="row g-4">
            @foreach($checkups as $checkup)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm hover-card">
                    <div class="card-header fw-bold text-center">
                        {{ \Carbon\Carbon::parse($checkup->date)->format('M d, Y') }}
                    </div>
                    <div class="card-body text-center">
                        <p><i class="bi bi-file-medical me-2"></i><strong>Type:</strong> {{ ucfirst($checkup->checkup_type) }}</p>
                        <p><i class="bi bi-person-circle me-2"></i><strong>Staff:</strong> {{ $checkup->staff->first_name ?? 'N/A' }}</p>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
