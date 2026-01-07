@extends('layouts.app')

@section('content')

<style>
body {
    background: linear-gradient(135deg, #dff6ff, #cce7ff);
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 0;
}

.checkup-container {
    width: 100%;
    padding: 30px 40px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 12px;
    border-top: 8px solid #0d6efd;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {opacity:0; transform: translateY(10px);}
    to {opacity:1; transform: translateY(0);}
}

h2 {
    font-weight: 700;
    color: #0d6efd;
    margin-bottom: 25px;
}

.table-container {
    width: 100%;
    overflow-x: auto;
    border-radius: 12px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    color: #000000;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

thead {
    background: #0d6efd;
    color: #ffffff;
}

th, td {
    padding: 16px 18px;
    font-size: 16px;
    border-bottom: 1px solid #eaeaea;
    text-align: left;
}

tbody tr:hover {
    background: #eef5ff;
    transition: 0.2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.btn-view {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 8px;
    background: #198754;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    font-size: 16px;
    transition: 0.2s;
}

.btn-view:hover {
    background: #157347;
    color: #fff;
}

@media (max-width: 768px) {
    .checkup-container {
        padding: 20px;
    }
    th, td {
        font-size: 14px;
        padding: 12px 10px;
    }
    .btn-view {
        padding: 6px 12px;
        font-size: 14px;
    }
}
</style>

<div class="checkup-container">

    @if(session('success'))
        <div class="alert alert-success text-center shadow-sm">{{ session('success') }}</div>
    @endif

    <h2>My Assigned Checkups</h2>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Checkup Type</th>
                    <th>Notes</th>
                    <th>Courses</th>
                    <th>Students</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkups as $checkup)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($checkup->date)->format('F j, Y') }}</td>
                        <td>{{ ucfirst($checkup->checkup_type) }}</td>
                        <td>{{ $checkup->notes ?? '-' }}</td>
                        <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            @php
                                $courses = $checkup->patients->map(function($student) {
                                    return $student->personalInformation->course ?? 'N/A';
                                })->unique()->implode(', ');
                            @endphp
                            {{ $courses }}
                        </td>
                        <td>
                            <a href="{{ route('staff.checkups.students', $checkup->id) }}" class="btn-view">
                                View Students
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $checkups->links() }}
    </div>

</div>

@endsection
