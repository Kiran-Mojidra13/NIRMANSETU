<!DOCTYPE html>
<html>
<head>
    <title>NirmanSetu Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-dark bg-dark p-3">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">Admin Panel</a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3">{{ auth()->user()->name }}</span>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
