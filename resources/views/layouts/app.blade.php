<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EnglishYa')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-" crossorigin="anonymous"></script>
</head>
<body>
    <x-toast />

    <div class="flex min-h-screen">
        @include('components.sidebar.'.Auth::User()->role)
        <div class="bg-background flex flex-1 flex-col">
            @include('components.topbar')
            
            @yield('content')
        </div>
    </div>


    <script>
    function dismissError() {
        document.getElementById('alert').style.display = 'none';
    }

    function showToast(type, message){
        let toast = $('#toast');
        toast.attr('variant', type);
        toast.find('[id$="-message"]').text(message);
        toast.removeClass('hidden');

        setTimeout(function(){
            toast.removeClass('opacity-0 translate-x-8');
        },10);

        setTimeout(function(){
            toast.addClass('opacity-0 translate-x-8');
            setTimeout(function(){
                toast.addClass('hidden');
            },300);
        },3000);
    }
    </script>
</body>
</html>