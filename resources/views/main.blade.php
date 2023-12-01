<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>sportsApp</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
        {{-- <link href="{{URL::asset('css/app.css')}}" rel="stylesheet"> --}}
        <script src="https://jsuites.net/v4/jsuites.js"></script>
        <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body>       
    <div class="">
        @yield('content')        
    </div>
    </body>
</html>