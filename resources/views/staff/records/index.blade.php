@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-dark fw-bold">Checkup Records</h1>

    @if($records->count() > 0)
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Checkup Date</th>
                    <th>Diagnosis</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $record->student->personalInformation->full_name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->checkup->date)->format('F j, Y') }}</td>
                        <td>{{ $record->diagnosis ?? 'Pending' }}</td>
                        <td>
                            <a href="{{ route('checkup_records.edit', $record->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $records->links() }}
    @else
        <p class="text-muted">No records found.</p>
    @endif
</div>
@endsection
