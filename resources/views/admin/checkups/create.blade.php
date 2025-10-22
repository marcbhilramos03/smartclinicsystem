@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Schedule Checkup</h2>

    <form action="{{ route('admin.checkups.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="staff_id" class="form-label">Assign Staff</label>
            <select name="staff_id" class="form-control" required>
                <option value="">Select Staff</option>
                @foreach($staff as $s)
                    <option value="{{ $s->user_id }}">{{ $s->first_name }} {{ $s->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="course" class="form-label">Course</label>
            <select name="course" class="form-control" required>
                <option value="">Select Course</option>
                @foreach($courses as $c)
                    <option value="{{ $c->course }}">{{ $c->course }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="checkup_type" class="form-label">Checkup Type</label>
            <select name="checkup_type" class="form-control" required>
                <option value="vitals">Vitals</option>
                <option value="dental">Dental</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Schedule Checkup</button>
    </form>
</div>
@endsection
