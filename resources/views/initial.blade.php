<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>sportsApp</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{URL::asset('css/app.css')}}" type="text/css">
        {{-- @vite('resources/css/app.css') --}}
    <body>
        <div class="initial">
            <form id="initial" action="{{route('sample.validate_initial')}}" method="get">
            @csrf
            <button type="submit"><img src="{{URL::asset('images/logo2.png')}}"/></button>
        </form>
        <script>
            setTimeout(function(){
                document.getElementById("initial").submit();
            },3000)
        </script>
        </div>
    </body>
</html>