@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Checkup Details</h2>
    <p>Checkup ID: {{ $checkup->id }}</p>
    <p>Date: {{ $checkup->date }}</p>
    <p>Description: {{ $checkup->description }}</p>

    <a href="{{ route('staff.checkups.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
