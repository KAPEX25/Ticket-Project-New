<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
    <title>@yield('title')</title>
</head>
<body>
    
    <div style="" class="banner">
        <div id="bannerdiv">
            <a class="buttondiv" href="{{ route('mainwelcome') }}">
                <p>Main</p>
            </a> 
           <a class="buttondiv" href="{{ route('filament.admin.pages.dashboard') }}">
                <p>Dashboard</p>
            </a>  
            @if(auth()->check() == false)
           <a class="buttondiv" href="{{ route('filament.admin.auth.login') }}">
                <p>Login</p>
            </a> 
           <a class="buttondiv" href="{{ route('register') }}">
                <p>Register</p>
            </a>  
            @endif
        </div>
    </div>
    <div style="display: flex;justify-content: center;height:100vh;align-items: center;">
        <div class="container">
            @yield('content')
        </div>
    </div>
    

</body>
</html>
