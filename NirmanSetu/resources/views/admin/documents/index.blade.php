@extends('adminlte::page')

@section('title', 'Document Center')

@section('content_header')
    <h1>Document Center</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Show upload button only for allowed roles --}}
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'engineer' || auth()->user()->role === 'contractor' || auth()->user()->role === 'client')
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary mb-3">+ Upload Document</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th><th>Type</th><th>File</th><th>Description</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $document)
                <tr>
                    <td>{{ $document->title }}</td>
                    <td>{{ $document->type }}</td>
                    <td>
                        <a href="{{ Storage::url($document->file_path) }}" target="_blank">View File</a>
                    </td>
                    <td>{{ $document->description }}</td>
                    <td>
                        {{-- Only uploader/admin can delete --}}
                        @if(auth()->id() === $document->uploaded_by || auth()->user()->role === 'admin')
                            <form action="{{ route('admin.documents.delete', $document->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No documents found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $documents->links() }}
@stop
