<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Team-Wallet</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{URL::asset('css/app.css')}}" rel="stylesheet">
        <script src="https://jsuites.net/v4/jsuites.js"></script>
        <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
        <link rel="icon" href="{{URL::asset('images/icon.png')}}" sizes="32x32" type="image/png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
        {{-- @vite('resources/css/app.css')
        @vite('resources/js/app.js') --}}
         {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn3.devexpress.com/jslib/23.1.6/css/dx.material.blue.light.css" />
    <script src="https://cdn3.devexpress.com/jslib/23.1.6/js/dx.all.js"></script>
    </head>
    <body>       
    <div class="">
        @yield('content')        
    </div>
    </body>
</html>