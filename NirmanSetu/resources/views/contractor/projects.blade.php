@extends('layouts.app')

@section('content')
<div class="p-6 bg-white shadow rounded-lg">

    <h2 class="text-2xl font-bold mb-4">📋 Assigned Projects</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Project Name</th>
                    <th class="px-4 py-2">Client</th>
                    <th class="px-4 py-2">Start Date</th>
                    <th class="px-4 py-2">End Date</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Location</th>
                    <th class="px-4 py-2">Docs</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($projects as $index => $project)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 text-blue-600 cursor-pointer" onclick="openModal({{ $project->id }})">
                        {{ $project->name }}
                    </td>
                    <td class="px-4 py-2">{{ $project->client_name }}</td>
                    <td class="px-4 py-2">{{ $project->start_date }}</td>
                    <td class="px-4 py-2">{{ $project->end_date }}</td>
                    <td class="px-4 py-2">{{ $project->status }}</td>
                    <td class="px-4 py-2">{{ $project->location }}</td>
                    <td class="px-4 py-2">
                        @if($project->docs)
                            <button onclick="openDocs('{{ json_encode($project->docs) }}')" class="text-blue-500 hover:underline">View Docs</button>
                        @else
                            <span class="text-gray-400 italic">No Docs</span>
                        @endif
                    </td>
                </tr>

                <!-- Modal -->
                <div id="modal-{{ $project->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative">
                        <h3 class="text-xl font-semibold mb-4">{{ $project->project_name }}</h3>
                        <p><strong>Client:</strong> {{ $project->client_name }}</p>
                        <p><strong>Description:</strong> {{ $project->description ?? 'Not available' }}</p>
                        <p><strong>Duration:</strong> {{ $project->start_date }} to {{ $project->end_date }}</p>
                        <p><strong>Status:</strong> {{ $project->status }}</p>
                        <p><strong>Location:</strong> {{ $project->location }}</p>
                        @if($project->map_iframe)
                            <div class="mt-4">
                                <iframe src="{{ $project->map_iframe }}" width="100%" height="200" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endif
                        <button onclick="closeModal({{ $project->id }})" class="absolute top-2 right-3 text-gray-500 hover:text-red-500">✖</button>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
        document.getElementById('modal-' + id).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.remove('flex');
        document.getElementById('modal-' + id).classList.add('hidden');
    }

    function openDocs(docsJson) {
        const docs = JSON.parse(docsJson);
        if (typeof docs === 'string') {
            window.open('/storage/' + docs, '_blank');
        } else if (Array.isArray(docs)) {
            let list = docs.map(doc => `<a href="/storage/${doc}" target="_blank" class="text-blue-600 hover:underline block">${doc}</a>`).join('');
            alert("Multiple files:\n\n" + list);
        }
    }
</script>

<script>
    lucide.createIcons();
</script>
@endsection
