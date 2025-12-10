@extends('client.layouts.app')

@section('title', 'My Documents')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">My Documents</h1>

    {{-- Search --}}
    <div class="mb-6 flex justify-center">
        <input type="text" id="search" placeholder="Search documents..."
               class="border p-2 rounded w-1/2" onkeyup="filterDocs()">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Projects docs first --}}
        @foreach($projects as $project)
            @if($project->docs)
                @foreach(json_decode($project->docs) as $doc)
                <div class="doc-card gradient-card p-4 rounded shadow hover:shadow-lg transition">
                    <h2 class="font-semibold text-lg mb-2 text-gray-50">{{ $project->name }} (Project Doc)</h2>
                    <a href="{{ asset($doc) }}" target="_blank" class="block text-white underline mb-2 truncate">{{ basename($doc) }}</a>
                    <div class="flex justify-between">
                        <a href="{{ asset($doc) }}" download class="btn-download text-white font-semibold px-3 py-1 rounded bg-white/20 hover:bg-white/30">Download</a>
                        <a href="{{ asset($doc) }}" target="_blank" class="btn-view text-white font-semibold px-3 py-1 rounded bg-white/20 hover:bg-white/30">View</a>
                    </div>
                </div>
                @endforeach
            @endif
        @endforeach

        {{-- Other documents --}}
        @foreach($documents as $document)
            <div class="doc-card p-4 rounded shadow hover:shadow-lg transition border border-gray-200">
                <h2 class="font-semibold text-lg mb-2 text-gray-700">{{ $document->title }}</h2>
                <p class="text-gray-500 mb-2 truncate">{{ $document->description }}</p>
                <div class="flex justify-between">
                    <a href="{{ asset($document->file_path) }}" download class="btn-download px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Download</a>
                    <a href="{{ asset($document->file_path) }}" target="_blank" class="btn-view px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">View</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Custom CSS --}}
<style>
.gradient-card {
    background: linear-gradient(135deg, #667eea, #764ba2);
}
.doc-card a {
    word-break: break-all;
}
</style>

{{-- Search Filter JS --}}
<script>
function filterDocs() {
    const input = document.getElementById('search').value.toLowerCase();
    const cards = document.querySelectorAll('.doc-card');
    cards.forEach(card => {
        const text = card.innerText.toLowerCase();
        card.style.display = text.includes(input) ? 'block' : 'none';
    });
}
</script>
@endsection
