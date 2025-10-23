@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Import Medical History</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.imports.medical_histories.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Upload Excel/CSV</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Import Medical History</button>
    </form>
</div>
@endsection
