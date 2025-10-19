@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add {{ ucfirst($checkup->checkup_type) }} Record for {{ $student->personalInformation->first_name }} {{ $student->personalInformation->last_name }}</h2>

    <form action="{{ route('staff.checkups.records.store', $checkup->id) }}" method="POST">
        @include('staff.checkup_records._record_form')
        <button type="submit" class="btn btn-success mt-3">Save Record</button>
    </form>
</div>
@endsection
