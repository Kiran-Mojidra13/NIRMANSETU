@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        📝 Submit Daily Progress
    </h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contractor.daily_update.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Project -->
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1">Project</label>
                <select name="project_id" id="project_id" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Task -->
            <div>
                <label for="task_id" class="block text-sm font-medium text-gray-700 mb-1">Task</label>
                <select name="task_id" id="task_id" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </select>
            </div>

            <!-- Work Hours -->
            <div>
                <label for="work_hours" class="block text-sm font-medium text-gray-700 mb-1">Work Hours</label>
                <input type="number" name="work_hours" step="0.1"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Labour Count -->
            <div>
                <label for="labour_count" class="block text-sm font-medium text-gray-700 mb-1">Labour Count</label>
                <input type="number" name="labour_count"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Date -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="not_started">Not Started</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="delayed">Delayed</option>
                </select>
            </div>
        </div>

        <!-- Work Description -->
        <div>
            <label for="progress_description" class="block text-sm font-medium text-gray-700 mb-1">Work Description</label>
            <textarea name="progress_description" rows="3"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required></textarea>
        </div>

        <!-- Work Done -->
        <div>
            <label for="work_done" class="block text-sm font-medium text-gray-700 mb-1">Work Done</label>
            <textarea name="work_done" rows="2"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required></textarea>
        </div>

        <!-- Remarks -->
        <div>
            <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks (Optional)</label>
            <textarea name="remarks" rows="2"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <!-- Photos -->
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label for="before_photo" class="block text-sm font-medium text-gray-700 mb-1">Before Work Photo (Optional)</label>
                <input type="file" name="before_photo"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="after_photo" class="block text-sm font-medium text-gray-700 mb-1">After Work Photo <span class="text-red-500">*</span></label>
                <input type="file" name="after_photo" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                🚀 Submit Progress
            </button>
        </div>
    </form>
</div>

<script>
    const taskMap = @json($tasksByProject); // Passed from controller
    document.getElementById('project_id').addEventListener('change', function () {
        let projectId = this.value;
        let taskSelect = document.getElementById('task_id');
        taskSelect.innerHTML = '<option value="">Select Task</option>';
        if (taskMap[projectId]) {
            taskMap[projectId].forEach(task => {
                let option = document.createElement('option');
                option.value = task.id;
                option.text = task.title;
                taskSelect.appendChild(option);
            });
        }
    });
</script>
@endsection
