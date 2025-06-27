@extends('adminlte::page')

@section('title', 'Manage Users')

@section('content_header')
    <h1>Manage Users</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ✅ Add New User Button --}}
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">+ Add New User</a>

    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search name or email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.toggleStatus', $user->id) }}">
                        @csrf
                        <button class="btn btn-sm {{ $user->status === 'active' ? 'btn-success' : 'btn-secondary' }}">
                            {{ ucfirst($user->status) }}
                        </button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="display:inline-block;">
                        @csrf
                        <button onclick="return confirm('Delete user?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
@stop
