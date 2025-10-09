@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>

    <div class="card p-3">
       <h4>Personal Information</h4>
<p><strong>Name:</strong> {{ $user->first_name ?? '' }} {{ $user->middle_name ?? '' }} {{ $user->last_name ?? '' }}</p>

@if($user->personalInformation)
    <p><strong>School ID:</strong> {{ $user->personalInformation->school_id }}</p>
    <p><strong>Age:</strong> {{ $user->personalInformation->birtdate }}</p>
    <p><strong>Address:</strong> {{ $user->personalInformation->address }}</p>
    <p><strong>Contact No:</strong> {{ $user->personalInformation->contact_number }}</p>
@else
    <p class="text-muted">No personal information available for this user.</p>
@endif

    </div>
</div>
@endsection
