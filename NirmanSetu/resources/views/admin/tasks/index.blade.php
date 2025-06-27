@extends('adminlte::page')

@section('title', 'Task Assignment')

@section('content_header')
    <h1>Task Assignment</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary mb-3">+ Assign New Task</a>

    <table class="table table-bordered table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Project</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->project->name ?? '-' }}</td>
                    <td>{{ $task->assignedTo->name ?? '-' }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>
                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.tasks.delete', $task->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button onclick="return confirm('Delete this task?')" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $tasks->links() }}
    </div>
@stop
