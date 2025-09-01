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
           <div class="buttondiv" href="{{view('pages.main')}}">
                <p>Main</p>
           </div> 
           <div class="buttondiv">
                <p>Dashboard</p>
           </div> 
           <div class="buttondiv">
                <p>Login</p>
           </div>
           <div class="buttondiv">
                <p>Register</p>
           </div> 
        </div>
    </div>
    <div style="display: flex;justify-content: center;height:100vh;align-items: center;">
        <div class="container">
            @yield('content')
        </div>
    </div>
    

</body>
</html>
