<aside class="w-64 bg-white border-r min-h-screen hidden md:block">
    <!-- Logo Section -->
    <div class="p-4 flex items-center space-x-3 border-b">
        <img src="{{ asset('images/nirmansetu-logo.png') }}" alt="NirmanSetu Logo" class="h-10 w-10 object-contain">
        <h1 class="text-lg font-bold text-gray-800">NirmanSetu</h1>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-2 text-gray-700">
        <a href="{{ route('contractor.dashboard') }}" class="flex items-center space-x-2 py-2 hover:text-blue-600">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('contractor.projects') }}" class="flex items-center space-x-2 py-2 hover:text-blue-600">
            <i data-lucide="folder-kanban" class="w-5 h-5"></i>
            <span>Projects</span>
        </a>
        <a href="{{ route('contractor.assigned-tasks') }}" class="flex items-center space-x-2 py-2 hover:text-blue-600">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span>Tasks</span>
        </a>
        <a href="{{ route('contractor.daily-updates') }}" class="flex items-center space-x-2 py-2 hover:text-blue-600">
            <i data-lucide="calendar-check" class="w-5 h-5"></i>
            <span>Daily Updates</span>
        </a>
      <a href="{{ route('contractor.site_images') }}" class="flex items-center space-x-2 py-2 hover:text-blue-600">
    <i data-lucide="image" class="w-5 h-5"></i>
    <span>Site Images</span>
</a>

        <a href="{{ route('contractor.calendar') }}" class="flex items-center space-x-2 py-2 hover:text-blue-600">
            <i data-lucide="calendar-days" class="w-5 h-5"></i>
            <span>Calendar</span>
        </a>
        {{-- <a href="{{ route('contractor.notifications') }}" class="flex items-center space-x-2 py-2 hover:text-blue-600">
            <i data-lucide="bell" class="w-5 h-5"></i>
            <span>Notifications</span>
        </a> --}}
        <a href="{{ route('contractor.profile.edit') }}" class="flex items-center space-x-2 py-2 hover:text-blue-600">
    <i data-lucide="user" class="w-5 h-5"></i>
    <span>Profile</span>
</a>

    </nav>
</aside>

<!-- Lucide Icon CDN -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
