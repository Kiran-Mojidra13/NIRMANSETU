@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">📅 Daily Progress Updates</h2>
        <a href="{{ route('contractor.daily_update.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add New Update
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm text-left border">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Project</th>
                    <th class="px-4 py-2 border">Description</th>
                    <th class="px-4 py-2 border">Before Photo</th>
                    <th class="px-4 py-2 border">After Photo</th>
                    <th class="px-4 py-2 border">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailyUpdates as $update)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $update->date }}</td>
                        <td class="px-4 py-2 border">{{ $update->project->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border truncate max-w-[200px]">{{ $update->progress_description }}</td>
                        <td class="px-4 py-2 border">
                            @if($update->before_photo)
                                <img src="{{ asset('storage/' . $update->before_photo) }}" class="w-16 h-16 object-cover rounded shadow">
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border">
                            @if($update->after_photo)
                                <img src="{{ asset('storage/' . $update->after_photo) }}" class="w-16 h-16 object-cover rounded shadow">
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border">
                            <button
                                class="text-blue-600 hover:underline font-medium"
                                onclick="openModal({{ $update->id }})"
                            >
                                View Details
                            </button>

                            <!-- Hidden modal content -->
                            <div id="modal-{{ $update->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                                <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-lg relative">
                                    <button onclick="closeModal({{ $update->id }})" class="absolute top-3 right-4 text-gray-500 hover:text-black text-xl">&times;</button>
                                    <h3 class="text-xl font-semibold mb-4">🧾 Progress Details</h3>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                        <div><strong>Date:</strong> {{ $update->date }}</div>
                                        <div><strong>Project:</strong> {{ $update->project->name ?? 'N/A' }}</div>
                                        <div><strong>Task ID:</strong> {{ $update->task_id }}</div>
                                        <div><strong>Work Hours:</strong> {{ $update->work_hours ?? 'N/A' }}</div>
                                        <div><strong>Labour Count:</strong> {{ $update->labour_count ?? 'N/A' }}</div>
                                        <div><strong>Status:</strong> {{ $update->status ?? 'N/A' }}</div>
                                    </div>

                                    <div class="mt-4">
                                        <strong>Description:</strong>
                                        <p class="text-gray-700">{{ $update->progress_description }}</p>
                                    </div>

                                    <div class="mt-3">
                                        <strong>Work Done:</strong>
                                        <p class="text-gray-700">{{ $update->work_done }}</p>
                                    </div>

                                    <div class="mt-3">
                                        <strong>Remarks:</strong>
                                        <p class="text-gray-700">{{ $update->remarks ?? '—' }}</p>
                                    </div>

                                    <div class="mt-4 grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="font-semibold mb-1">Before Photo:</p>
                                            @if($update->before_photo)
                                                <img src="{{ asset('storage/' . $update->before_photo) }}" class="rounded shadow">
                                            @else
                                                <p class="text-gray-400">No before photo</p>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold mb-1">After Photo:</p>
                                            @if($update->after_photo)
                                                <img src="{{ asset('storage/' . $update->after_photo) }}" class="rounded shadow">
                                            @else
                                                <p class="text-gray-400">No after photo</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-6 text-right space-x-2">
                                        <!-- Update Form -->
                                        <form action="{{ route('contractor.daily-updates.update', $update->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="title" value="{{ $update->title }}">
                                            <input type="hidden" name="progress" value="{{ $update->progress }}">
                                            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">Quick Update</button>
                                        </form>

                                        <!-- Delete Form -->
                                        <form action="{{ route('contractor.daily-updates.destroy', $update->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                                        </form>

                                        <button onclick="closeModal({{ $update->id }})"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No updates found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(`modal-${id}`).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(`modal-${id}`).classList.add('hidden');
    }
</script>
@endsection
