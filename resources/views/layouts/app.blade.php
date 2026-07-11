<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EnglishYa')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-" crossorigin="anonymous"></script>
</head>
<body>
    <div class="flex min-h-screen">
        @if (Auth::user()->role == 'admin')
            @include('components.sidebar')
        @elseif (Auth::user()->role == 'parent')
            @include('components.parentsidebar')
        @endif
        <div class="flex flex-1 flex-col">
            @include('components.topbar')
            
            @yield('content')
        </div>
    </div>


    <script>
    function dismissError() {
        document.getElementById('alert').style.display = 'none';
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
</body>
</html>