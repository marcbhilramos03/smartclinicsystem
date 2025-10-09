@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Checkup: {{ $checkup->patient->first_name }} {{ $checkup->patient->last_name }}</h1>

    <form action="{{ route('staff.checkups.update', $checkup) }}" method="POST">
        @csrf
        @method('PUT')

        @if($checkup->checkup_type === 'vitals')
            <h4>Vitals</h4>
            <input type="number" name="vitals[height]" placeholder="Height">
            <input type="number" name="vitals[weight]" placeholder="Weight">
            <input type="text" name="vitals[blood_pressure]" placeholder="BP">
            <input type="text" name="vitals[pulse_rate]" placeholder="Pulse">
            <input type="number" name="vitals[temperature]" placeholder="Temperature">
            <input type="number" name="vitals[respiratory_rate]" placeholder="Respiratory Rate">
            <input type="number" name="vitals[bmi]" placeholder="BMI">
        @elseif($checkup->checkup_type === 'dental')
            <h4>Dental</h4>
            <input type="text" name="dental[status]" placeholder="Dental Status">
            <textarea name="dental[notes]" placeholder="Notes"></textarea>
        @endif

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
