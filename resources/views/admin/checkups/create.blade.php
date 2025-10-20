@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Create Checkup</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.checkups.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Staff</label>
            <select name="staff_id" class="form-select" required>
                <option value="">-- Select Staff --</option>
                @foreach($staff as $s)
                    <option value="{{ $s->user_id }}">{{ $s->first_name }} {{ $s->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Course</label>
            <select name="course_information_id" class="form-select" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $c)
                    <option value="{{ $c->id }}">{{ $c->course}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Checkup Type</label>
            <select name="checkup_type" class="form-select" required>
                <option value="">-- Select Type --</option>
                <option value="vital">Vital</option>
                <option value="dental">Dental</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Checkup</button>
    </form>
</div>
@endsection
