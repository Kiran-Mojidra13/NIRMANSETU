<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Client Portal - NirmanSetu')</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    @include('client.layouts.navbar')

    {{-- Sidebar --}}
    @include('client.layouts.sidebar')

    {{-- Content --}}
    <div class="content-wrapper p-3">
        @yield('content_header')

        <section class="content">
            @yield('content')
        </section>
    </div>

    {{-- Footer --}}
    @include('client.layouts.footer')

</div>

<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
