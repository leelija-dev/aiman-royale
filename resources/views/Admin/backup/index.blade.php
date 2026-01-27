@extends('Admin.layouts.master')

@section('source', 'Backup')
@section('page-title', 'Database Backups')

@section('content')
<div class="container">
    <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span>Database Backup List</span>
        <form action="{{ route('backup.create') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Create Backup</button>
        </form>
    </h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>File Name</th>
                <!-- <th>Created At</th> -->
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            @foreach($backups as $backup)
            <tr>
                <td>{{ $backup->file_name }}</td>
                <!-- <td>{{ $backup->created_at }}</td> -->
                <td>
    <a href="{{ route('backup.download', $backup->file_name) }}" class="btn btn-sm btn-success">Download</a>
    <!-- <a href="{{ route('backup.restore', $backup->file_name) }}" class="btn btn-sm btn-danger"
       onclick="return confirm('Are you sure you want to restore this backup? This will erase all current data!');">
        Restore
    </a> -->
</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
