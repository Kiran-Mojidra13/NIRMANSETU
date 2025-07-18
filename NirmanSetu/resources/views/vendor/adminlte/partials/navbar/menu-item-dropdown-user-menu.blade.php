@php
    $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout');
    $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout');

    if (config('adminlte.usermenu_profile_url', false)) {
        $profile_url = Auth::user()->adminlte_profile_url();
    }

    if (config('adminlte.use_route_url', false)) {
        $profile_url = $profile_url ? route($profile_url) : '';
        $logout_url = $logout_url ? route($logout_url) : '';
    } else {
        $profile_url = $profile_url ? url($profile_url) : '';
        $logout_url = $logout_url ? url($logout_url) : '';
    }
@endphp



{{-- 👤 User Menu --}}
<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if(config('adminlte.usermenu_image'))
            <img src="{{ Auth::user()->adminlte_image() }}"
                 class="user-image img-circle elevation-2"
                 alt="{{ Auth::user()->name }}">
        @endif
        <span @if(config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->name }}
        </span>
    </a>

    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- Header --}}
        @if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
            <li class="user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
                @if(!config('adminlte.usermenu_image')) h-auto @endif">
                @if(config('adminlte.usermenu_image'))
                    <img src="{{ Auth::user()->adminlte_image() }}"
                         class="img-circle elevation-2"
                         alt="{{ Auth::user()->name }}">
                @endif
                <p class="@if(!config('adminlte.usermenu_image')) mt-0 @endif">
                    {{ Auth::user()->name }}
                    @if(config('adminlte.usermenu_desc'))
                        <small>{{ Auth::user()->adminlte_desc() }}</small>
                    @endif
                </p>
            </li>
        @else
            @yield('usermenu_header')
        @endif

        {{-- Configured Links --}}
        @each('adminlte::partials.navbar.dropdown-item', $adminlte->menu("navbar-user"), 'item')

        {{-- Body Section --}}
        @hasSection('usermenu_body')
            <li class="user-body">
                @yield('usermenu_body')
            </li>
        @endif

        {{-- Footer --}}
     <li class="user-footer d-flex justify-content-between">

    {{-- Profile Update Button --}}
    <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">
        <i class="fa fa-fw fa-user text-info"></i> Update Profile
    </a>

    {{-- Logout Button --}}
    <a href="#" class="btn btn-default btn-flat text-danger"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-fw fa-power-off text-danger"></i> Log Out
    </a>

    {{-- Logout Form --}}
    <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
        @if(config('adminlte.logout_method'))
            {{ method_field(config('adminlte.logout_method')) }}
        @endif
        {{ csrf_field() }}
    </form>

</li>

    </ul>
</li>
