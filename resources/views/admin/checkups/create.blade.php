@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Schedule Checkup</h1>
    <form action="{{ route('admin.checkups.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Student</label>
            <select name="user_id" class="form-control">
                @foreach($students as $student)
                    <option value="{{ $student->user_id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Staff</label>
            <select name="staff_id" class="form-control">
                @foreach($staffs as $staff)
                    <option value="{{ $staff->user_id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Checkup Type</label>
            <select name="checkup_type" class="form-control">
                <option value="vitals">Vitals</option>
                <option value="dental">Dental</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Schedule</button>
    </form>
</div>
@endsection
