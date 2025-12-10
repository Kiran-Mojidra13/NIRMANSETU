<header class="bg-white border-b flex items-center justify-between px-4 py-2 shadow-sm">
    <div class="md:hidden">
        <!-- Mobile menu button -->
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <div class="text-lg font-semibold">Dashboard</div>

   <div class="flex items-center space-x-4">
    <span class="text-sm text-gray-700">Hi, {{ Auth::user()->name ?? 'Guest' }}</span>

    @if(Auth::check() && Auth::user()->profile_photo_path)
        {{-- Show uploaded profile photo --}}
        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
             class="h-8 w-8 rounded-full object-cover border" alt="User Avatar">
    @else
        {{-- Fallback: auto avatar --}}
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'G') }}"
             class="h-8 w-8 rounded-full" alt="Default Avatar">
    @endif

    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ route('logout') }}" class="dropdown-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>

</header>
