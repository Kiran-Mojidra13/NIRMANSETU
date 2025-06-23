<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">NirmanSetu Admin</a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" width="30" class="rounded-circle">
                {{ auth()->user()->name }}
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">Edit Profile</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Logout</button>
                </form>
            </div>
        </li>
    </ul>
</nav>
