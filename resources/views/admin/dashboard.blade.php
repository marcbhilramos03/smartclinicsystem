@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
    </div>
    <!-- Dashboard Cards -->
    <div class="row">
        <!-- Total Staff -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Staff</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStaff ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Total Patients -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Patients</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPatients ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Patient Not Found Modal -->
@if(session('showPatientNotFoundModal'))
<div class="modal fade" id="patientNotFoundModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Patient Not Found</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        No patient found with School ID: <strong>{{ session('searchTerm') }}</strong>
      </div>
      <div class="modal-footer">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('patientNotFoundModal');
    if (modalEl) {
        var myModal = new bootstrap.Modal(modalEl);
        myModal.show();
    }
});
</script>
@endif

@endsection
