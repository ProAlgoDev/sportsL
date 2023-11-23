<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>sportsApp</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{URL::asset('css/app.css')}}" rel="stylesheet">
        @vite('resources/css/app.css')
    </head>
    <body>       
    <div class="">
        @yield('content')        
    </div>
    </body>
</html>