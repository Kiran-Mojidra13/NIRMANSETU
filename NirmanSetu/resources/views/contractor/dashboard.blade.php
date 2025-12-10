@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">👷 Contractor Dashboard</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl p-4 shadow-md">
            <h2 class="text-lg font-semibold mb-2">📦 Total Assigned Projects</h2>
            <p class="text-2xl font-bold">{{ $totalProjects }}</p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow-md">
            <h2 class="text-lg font-semibold mb-2">📋 Total Progress Entries</h2>
            <p class="text-2xl font-bold">{{ $totalProgressEntries }}</p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow-md">
            <h2 class="text-lg font-semibold mb-2">📅 Today's Submissions</h2>
            <p class="text-2xl font-bold">{{ $todayProgress }}</p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow-md">
            <h2 class="text-lg font-semibold mb-2">🚨 Upcoming Deadlines (7 days)</h2>
            <p class="text-2xl font-bold">{{ $upcomingDeadlines }}</p>
        </div>
    </div>

    <!-- Add more dashboard sections here -->
</div>

<script>
    lucide.createIcons();
</script>
@endsection
