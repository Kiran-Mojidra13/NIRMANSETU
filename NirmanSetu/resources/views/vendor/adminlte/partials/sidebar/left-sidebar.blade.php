<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="brand-link d-flex align-items-center">
        <img src="{{ asset('storage/images/nirman.png') }}"
             alt="NirmanSetu Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .9; width: 40px; height: 40px; object-fit: cover;">

        <span class="brand-text font-weight-bold ml-2"
              style="font-family: 'Poppins', sans-serif; border-radius: 12px; padding: 4px 8px; background: rgba(255,255,255,0.1);">
            NirmanSetu
        </span>
    </a>

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>
