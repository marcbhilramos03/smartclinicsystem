@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Assigned Checkups</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Date</th>
                <th>Vitals/Dental</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkups as $checkup)
            <tr>
                <td>{{ $checkup->patient->first_name }} {{ $checkup->patient->last_name }}</td>
                <td>{{ $checkup->date }}</td>
                <td>
                    @if($checkup->vitals || $checkup->dental)
                        Completed
                    @else
                        Pending
                    @endif
                </td>
                <td><a href="{{ route('staff.checkups.show', $checkup) }}" class="btn btn-primary btn-sm">Fill Checkup</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $checkups->links() }}
</div>
@endsection
