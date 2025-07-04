@extends('adminlte::page')

@section('title', 'Upload Document')

@section('content_header')
    <h1>Upload Document</h1>
@stop

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label>File:</label>
            <input type="file" name="file" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Type:</label>
            <input type="text" name="type" class="form-control" value="{{ old('type') }}">
        </div>

        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        {{-- Show Client & Project only for admin --}}
        @if(auth()->user()->role === 'admin')
            <div class="mb-3">
                <label>Client (optional):</label>
                <select name="client_id" class="form-control">
                    <option value="">-- None --</option>
                    {{-- Fill with your client users --}}
                    @foreach(\App\Models\User::where('role', 'client')->get() as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Project (optional):</label>
                <select name="project_id" class="form-control">
                    <option value="">-- None --</option>
                    {{-- Fill with your projects --}}
                    @foreach(\App\Models\Project::all() as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <button class="btn btn-success">Upload</button>
    </form>
@stop
