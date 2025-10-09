@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="text-center mb-4">
        <h1 class="h3 text-gray-800">Patient Dashboard</h1>
        <p>Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
    </div>

    <div class="row">
        <!-- Example Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Appointments</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
