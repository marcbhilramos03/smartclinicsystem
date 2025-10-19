@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit {{ ucfirst($checkup->checkup_type) }} Record for {{ $student->personalInformation->first_name }} {{ $student->personalInformation->last_name }}</h2>

    <form action="{{ route('staff.checkups.records.update', [$checkup->id, $record->id]) }}" method="POST">
        @method('PUT')
        @include('staff.checkup_records._record_form')
        <button type="submit" class="btn btn-primary mt-3">Update Record</button>
    </form>
</div>
@endsection
