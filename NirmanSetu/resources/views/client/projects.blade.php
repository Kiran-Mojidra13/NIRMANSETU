@extends('client.layouts.app')

@section('title', 'My Projects')

<style>
    .gradient-btn {
        background-image: linear-gradient(to right, #243987, #4362d2) !important; /* Indigo → Pink */
        color: #fff !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .gradient-btn:hover {
        background-image: linear-gradient(to right, #ec4899, #8b5cf6) !important;
    }

    .gradient-docs {
        background-image: linear-gradient(to right, #4192ab, #0a4d80) !important; /* Yellow → Orange */
        color: #fff !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .gradient-docs:hover {
        background-image: linear-gradient(to right, #f97316, #facc15) !important;
    }

    .gradient-apply {
        background-image: linear-gradient(to right, #f472b6, #a78bfa) !important; /* Pink → Purple */
        color: #fff !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .gradient-apply:hover {
        background-image: linear-gradient(to right, #a78bfa, #f472b6) !important;
    }
</style>


@section('content')
<div class="container mx-auto p-4">

    {{-- Filters --}}
    <div class="flex flex-wrap items-center mb-6 gap-4">
        <input type="text" id="search" placeholder="Search projects..." class="border p-2 rounded" value="{{ request('search') }}" />
        <select id="status" class="border p-2 rounded">
            <option value="">All Status</option>
            <option value="planned" @if(request('status')=='planned') selected @endif>Planned</option>
            <option value="in_progress" @if(request('status')=='in_progress') selected @endif>In Progress</option>
            <option value="completed" @if(request('status')=='completed') selected @endif>Completed</option>
            <option value="on_hold" @if(request('status')=='on_hold') selected @endif>On Hold</option>
            <option value="delayed" @if(request('status')=='delayed') selected @endif>Delayed</option>
        </select>
        <select id="sort" class="border p-2 rounded">
            <option value="start_date" @if(request('sort')=='start_date') selected @endif>Start Date</option>
            <option value="end_date" @if(request('sort')=='end_date') selected @endif>End Date</option>
            <option value="created_at" @if(request('sort')=='created_at') selected @endif>Created Date</option>
        </select>
<button id="applyFilter" class="px-4 py-2 rounded text-sm gradient-apply">
    Apply
</button>
    </div>

    {{-- Projects Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
        <div class="border rounded-lg shadow p-4 bg-white">

            {{-- Image --}}
            <img src="{{ $project->image_url ?? 'https://via.placeholder.com/400x200?text=No+Image' }}" class="w-full h-40 object-cover rounded" alt="Project Image">

            {{-- Basic Info --}}
            <h3 class="text-xl font-bold mt-2">{{ $project->name }}</h3>
            <p class="text-gray-600">{{ $project->description }}</p>
            <span class="inline-block mt-2 px-2 py-1 text-sm rounded
                @if($project->status=='planned') bg-gray-300
                @elseif($project->status=='in_progress') bg-blue-200
                @elseif($project->status=='completed') bg-green-200
                @elseif($project->status=='on_hold') bg-yellow-200
                @elseif($project->status=='delayed') bg-red-200 @endif
            ">
                {{ ucfirst(str_replace('_',' ',$project->status)) }}
            </span>

            <p class="text-sm text-gray-500 mt-1">Location: {{ $project->location }}</p>
            <p class="text-sm text-gray-500">Start: {{ $project->start_date }} | End: {{ $project->end_date }}</p>

            {{-- Progress --}}
            @php
                $tasks = $tasksByProject[$project->id] ?? collect([]);
                $completed = $tasks->where('status','completed')->count();
                $totalTasks = $tasks->count();
                $progress = $totalTasks ? round(($completed/$totalTasks)*100) : 0;
            @endphp
            <div class="w-full bg-gray-200 h-3 rounded mt-2">
                <div class="bg-green-500 h-3 rounded" style="width: {{ $progress }}%"></div>
            </div>
            <p class="text-sm text-gray-500 mt-1">Progress: {{ $progress }}%</p>

            {{-- Action Buttons --}}
           <div class="flex gap-2 mt-3">
    <button data-project-id="{{ $project->id }}" class="view-details px-3 py-1 rounded text-sm gradient-btn">
        View Details
    </button>

    @if(!empty($project->docs))
        <a href="{{ json_decode($project->docs)[0] ?? '#' }}" target="_blank" class="px-3 py-1 rounded text-sm gradient-docs">
            Download Docs
        </a>
    @endif
</div>


            {{-- Expanded Details --}}
            <div id="details-{{ $project->id }}" class="mt-4 border-t pt-4" style="display:none;">
                <h4 class="font-bold text-lg">{{ $project->name }} - Details</h4>
                <p>{{ $project->description }}</p>
                <p>Status: <span class="font-semibold">{{ ucfirst(str_replace('_',' ',$project->status)) }}</span></p>
                <p>Created By: {{ $usersById[$project->created_by] ?? 'N/A' }}</p>
                <p>Start: {{ $project->start_date }} | End: {{ $project->end_date }}</p>

                {{-- Docs --}}
                <div class="mt-2">
                    <h5 class="font-semibold">Attachments:</h5>
                    @if(!empty($project->docs))
                        @foreach(json_decode($project->docs) as $doc)
                        <a href="{{ $doc }}" target="_blank" class="text-blue-500 underline block">{{ basename($doc) }}</a>
                        @endforeach
                    @else
                        <p>No attachments</p>
                    @endif
                </div>

                {{-- Image --}}
                @if(!empty($project->image_url))
                <div class="mt-2">
                    <h5 class="font-semibold">Image:</h5>
                    <img src="{{ $project->image_url }}" class="w-full h-40 object-cover rounded">
                </div>
                @endif

                {{-- Tasks Table --}}
                @if($totalTasks)
                <div class="mt-4 overflow-x-auto">
                    <h5 class="font-bold mb-2">Tasks</h5>
                    <table class="table-auto w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-2 py-1">Title</th>
                                <th class="border px-2 py-1">Description</th>
                                <th class="border px-2 py-1">Details</th>
                                <th class="border px-2 py-1">Assigned To</th>
                                <th class="border px-2 py-1">Status</th>
                                <th class="border px-2 py-1">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            <tr>
                                <td class="border px-2 py-1">{{ $task->title }}</td>
                                <td class="border px-2 py-1">{{ $task->description }}</td>
                                <td class="border px-2 py-1">{{ $task->details }}</td>
                                <td class="border px-2 py-1">{{ $usersById[$task->assigned_to] ?? 'N/A' }}</td>
                                <td class="border px-2 py-1">
                                    <span class="px-2 py-1 rounded text-white
                                        @if($task->status=='completed') bg-green-500
                                        @elseif($task->status=='in_progress') bg-blue-500
                                        @elseif($task->status=='pending') bg-yellow-500
                                        @elseif($task->status=='delayed') bg-red-500 @endif
                                    ">
                                        {{ ucfirst(str_replace('_',' ',$task->status)) }}
                                    </span>
                                </td>
                                <td class="border px-2 py-1">{{ $task->due_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Chart.js --}}
                <canvas id="chart-{{ $project->id }}" class="mt-4 h-32 w-full"></canvas>
                <script>
                    const ctx{{ $project->id }} = document.getElementById('chart-{{ $project->id }}').getContext('2d');
                    new Chart(ctx{{ $project->id }}, {
                        type: 'doughnut',
                        data: {
                            labels: ['Completed', 'Remaining'],
                            datasets: [{
                                data: [{{ $completed }}, {{ $totalTasks - $completed }}],
                                backgroundColor: ['#34D399','#E5E7EB']
                            }]
                        },
                        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
                    });
                </script>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle details
    document.querySelectorAll('.view-details').forEach(function(btn){
        btn.addEventListener('click', function() {
            const projectId = this.dataset.projectId;
            const detailsEl = document.getElementById('details-' + projectId);
            if(detailsEl.style.display === 'none' || detailsEl.style.display === '') {
                detailsEl.style.display = 'block';
            } else {
                detailsEl.style.display = 'none';
            }
        });
    });

    // Filter
    document.getElementById('applyFilter').addEventListener('click', function() {
        const search = document.getElementById('search').value;
        const status = document.getElementById('status').value;
        const sort = document.getElementById('sort').value;
        const url = new URL(window.location.href);
        url.searchParams.set('search', search);
        url.searchParams.set('status', status);
        url.searchParams.set('sort', sort);
        window.location.href = url.toString();
    });
});
</script>
@endsection
