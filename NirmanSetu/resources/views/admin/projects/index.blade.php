@extends('adminlte::page')

@section('title', 'Manage Projects')

@section('content_header')
    <h1>Manage Projects</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Add New Project --}}
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mb-3">+ Add New Project</a>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.projects.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search project..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    {{-- Projects Table --}}
    <table class="table table-bordered table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Start</th>
                <th>End</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    <td>{{ $project->created_by }}</td>
                    <td>
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.projects.delete', $project->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button onclick="return confirm('Delete this project?')" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <form action="{{ route('admin.projects.archive', $project->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-secondary btn-sm">Archive</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No projects found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $projects->links() }}
    </div>
@stop
