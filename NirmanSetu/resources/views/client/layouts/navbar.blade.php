<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar: toggle -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar: Logo/Name + Client Name + Logout -->
    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item d-flex align-items-center">

 @php
    $user = Auth::user();
    $logo = $user->profile_photo_path ?? null;
@endphp

@if($logo && file_exists(storage_path('app/public/' . $logo)))
    <img src="{{ asset('storage/'.$logo) }}?{{ time() }}"
         alt="Logo" class="mr-2 rounded" style="height:30px; width:auto;">
@else
    <span class="rounded-circle d-flex justify-content-center align-items-center text-white mr-2"
          style="height:30px; width:30px; background-color:#007bff; font-weight:bold;">
        {{ strtoupper(substr($user->name,0,1)) }}
    </span>
@endif





            <!-- Client Name -->
            <span class="font-weight-bold mr-3">{{ $user->name }}</span>

            <!-- Logout button -->
            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm d-flex align-items-center"
               onclick="event.preventDefault();document.getElementById('logout-form-navbar').submit();">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </a>

            <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </li>
    </ul>
</nav>
