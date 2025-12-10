@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    {{-- Page Title --}}
    <h1 class="text-2xl font-bold mb-6">Calendar</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Left: Main Calendar --}}
        <div class="lg:col-span-3 bg-white rounded-2xl shadow p-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <button id="prevBtn" class="px-3 py-2 rounded-lg border">Prev</button>
                    <button id="todayBtn" class="px-3 py-2 rounded-lg border">Today</button>
                    <button id="nextBtn" class="px-3 py-2 rounded-lg border">Next</button>
                </div>
                <div class="flex items-center space-x-2">
                    <button data-view="dayGridMonth" class="viewBtn px-3 py-2 rounded-lg border">Month</button>
                    <button data-view="timeGridWeek" class="viewBtn px-3 py-2 rounded-lg border">Week</button>
                    <button data-view="timeGridDay" class="viewBtn px-3 py-2 rounded-lg border">Day</button>
                </div>
            </div>
            <div id="calendar" class="rounded-xl overflow-hidden"></div>
        </div>

        {{-- Right Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Filters --}}
            <div class="bg-white rounded-2xl shadow p-4">
                <h3 class="font-semibold mb-3">Filters</h3>
                <label class="flex items-center space-x-2 mb-2">
                    <input type="checkbox" class="category" value="task" checked>
                    <span>
                        <span class="h-3 w-3 inline-block rounded-full mr-2" style="background:#2563eb"></span>
                        Task Deadlines
                    </span>
                </label>
                <label class="flex items-center space-x-2 mb-2">
                    <input type="checkbox" class="category" value="milestone" checked>
                    <span>
                        <span class="h-3 w-3 inline-block rounded-full mr-2" style="background:#16a34a"></span>
                        Project Milestones
                    </span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="category" value="visit" checked>
                    <span>
                        <span class="h-3 w-3 inline-block rounded-full mr-2" style="background:#f59e0b"></span>
                        Site Visits
                    </span>
                </label>
            </div>

            {{-- Search + Add Visit --}}
            <div class="bg-white rounded-2xl shadow p-4 space-y-3">
                <input id="searchInput" type="text" placeholder="Search by project"
                       class="w-full border rounded-lg px-3 py-2">
                <button id="addVisitBtn" class="w-full bg-blue-600 text-white rounded-lg px-3 py-2">
                    + Add Visit
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Add Visit Modal --}}
<div id="visitModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow p-6 relative">
        <button id="closeVisitModal" class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded">X</button>
        <h2 class="text-xl font-bold mb-4">Add Site Visit</h2>
        <form id="visitForm" action="{{ route('contractor.site_visits.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Project</label>
                <select name="project_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Select project</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Visit Date</label>
                    <input type="date" name="visit_date" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Time (optional)</label>
                    <input type="time" name="time" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Place / Location</label>
                <input type="text" name="place" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Description / Notes</label>
                <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>
            <div class="pt-2">
                <button class="bg-blue-600 text-white rounded-lg px-4 py-2">Save Visit</button>
            </div>
        </form>
    </div>
</div>

{{-- Event Details Modal --}}
<div id="eventModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white w-full max-w-xl rounded-2xl shadow p-6 relative">
        <button id="closeEventModal" class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded">X</button>
        <h2 class="text-xl font-bold mb-4">Event Details</h2>
        <div class="space-y-2">
            <div><span class="font-semibold">Title:</span> <span id="evtTitle"></span></div>
            <div><span class="font-semibold">Category:</span> <span id="evtCategory"></span></div>
            <div><span class="font-semibold">Project:</span> <span id="evtProject"></span></div>
            <div><span class="font-semibold">When:</span> <span id="evtWhen"></span></div>
            <div><span class="font-semibold">Place:</span> <span id="evtPlace"></span></div>
            <div><span class="font-semibold">Notes:</span> <span id="evtDesc"></span></div>
        </div>
    </div>
</div>

{{-- FullCalendar --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const getCategories = () => Array.from(document.querySelectorAll('.category:checked')).map(c => c.value).join(',');
    const getSearch = () => document.getElementById('searchInput').value.trim();

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: false,
        height: 'auto',
        events: {
            url: '{{ route('contractor.calendar.events') }}', // backend merges tasks, projects, visits
            method: 'GET',
            extraParams: () => ({
                categories: getCategories(),
                search: getSearch()
            }),
            failure: () => alert('Failed to load events.')
        },
        eventClick: function(info) {
            const ev = info.event;
            const p  = ev.extendedProps || {};
            document.getElementById('evtTitle').innerText = ev.title;
            document.getElementById('evtCategory').innerText = p.category || '';
            document.getElementById('evtProject').innerText = p.project_name || '';
            document.getElementById('evtWhen').innerText = ev.startStr || '';
            document.getElementById('evtPlace').innerText = p.place || '';
            document.getElementById('evtDesc').innerText = p.description || '';
            document.getElementById('eventModal').classList.remove('hidden');
        }
    });
    calendar.render();

    // Controls
    document.getElementById('prevBtn').onclick = () => calendar.prev();
    document.getElementById('nextBtn').onclick = () => calendar.next();
    document.getElementById('todayBtn').onclick = () => calendar.today();
    document.querySelectorAll('.viewBtn').forEach(btn => {
        btn.addEventListener('click', () => calendar.changeView(btn.dataset.view));
    });
    document.querySelectorAll('.category').forEach(cb => cb.addEventListener('change', () => calendar.refetchEvents()));
    document.getElementById('searchInput').addEventListener('input', () => calendar.refetchEvents());

    // Visit modal
    document.getElementById('addVisitBtn').onclick = () => document.getElementById('visitModal').classList.remove('hidden');
    document.getElementById('closeVisitModal').onclick = () => document.getElementById('visitModal').classList.add('hidden');
    document.getElementById('closeEventModal').onclick = () => document.getElementById('eventModal').classList.add('hidden');
});
</script>
@endsection
