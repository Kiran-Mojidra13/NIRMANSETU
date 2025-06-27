@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@stop
