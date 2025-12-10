@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    {{-- ✅ Page Title --}}
    <h1 class="text-2xl font-bold mb-6">Site Images</h1>

    {{-- Search + Add Button --}}
    <div class="flex justify-between items-center mb-6">
        <form method="GET" class="flex space-x-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search projects..."
                   class="border px-4 py-2 rounded-lg">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Search</button>
        </form>
    </div>

    @if($projects->isEmpty())
        <p class="text-gray-500">No projects found.</p>
    @else
        <div class="space-y-6">
            @foreach($projects as $project)
                @php
                    // ✅ Decode JSON instead of explode()
                    $images = $project->image_url ? json_decode($project->image_url, true) : [];
                @endphp

                <div class="bg-white shadow-lg rounded-xl p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">{{ $project->id }} - {{ $project->name }}</h3>

                        <form action="{{ route('contractor.site_images.store', $project->id) }}"
                              method="POST" enctype="multipart/form-data" class="flex space-x-2">
                            @csrf
                            <input type="file" name="images[]" multiple class="border p-2 rounded">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add</button>
                        </form>
                    </div>

                    {{-- Images Preview --}}
                    <div class="grid grid-cols-5 gap-4">
                        @forelse(array_slice($images, 0, 5) as $img)
                            <div class="relative">
                                <img src="{{ $img }}" class="w-full h-32 object-cover rounded-lg shadow">
                                <form action="{{ route('contractor.site_images.destroy', $project->id) }}"
                                      method="POST" class="absolute top-1 right-1">
                                    @csrf @method('DELETE')
                                    <input type="hidden" name="image_url" value="{{ $img }}">
                                    <button class="bg-red-600 text-white text-xs px-2 py-1 rounded">X</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-400 col-span-5">No images uploaded yet.</p>
                        @endforelse
                    </div>

                    {{-- More Button --}}
                    @if(count($images) > 5)
                        <button onclick="openModal({{ $project->id }})"
                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg">
                            View More
                        </button>
                    @endif
                </div>

                {{-- Modal for all images --}}
                <div id="modal-{{ $project->id }}"
                     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-6 w-3/4 max-h-[80vh] overflow-y-auto relative">
                        <button onclick="closeModal({{ $project->id }})"
                                class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded">
                            Close
                        </button>
                        <h2 class="text-xl font-bold mb-4">All Images - {{ $project->name }}</h2>
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($images as $img)
                                <div class="relative">
                                    <img src="{{ $img }}" class="w-full h-40 object-cover rounded-lg shadow">
                                    <form action="{{ route('contractor.site_images.destroy', $project->id) }}"
                                          method="POST" class="absolute top-1 right-1">
                                        @csrf @method('DELETE')
                                        <input type="hidden" name="image_url" value="{{ $img }}">
                                        <button class="bg-red-600 text-white text-xs px-2 py-1 rounded">X</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @endif
</div>

<script>
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script>
@endsection
