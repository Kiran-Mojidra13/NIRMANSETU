@extends('adminlte::page')

@section('title', 'Edit Document')

@section('content_header')
    <h1>Edit Document</h1>
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

    <form method="POST" action="{{ route('admin.documents.update', $document->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $document->title) }}">
        </div>

        <div class="mb-3">
            <label>Type:</label>
            <input type="text" name="type" class="form-control" value="{{ old('type', $document->type) }}">
        </div>

        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control">{{ old('description', $document->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Replace File (optional):</label>
            <input type="file" name="file" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
    </form>
@stop
