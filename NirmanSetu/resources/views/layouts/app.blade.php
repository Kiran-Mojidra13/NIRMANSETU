<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NirmanSetu Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="flex flex-1">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col">
            @include('layouts.header')

            <main class="p-4 flex-1 overflow-y-auto">
                @yield('content')
            </main>

            @include('layouts.footer')
        </div>
    </div>

</body>
</html>
