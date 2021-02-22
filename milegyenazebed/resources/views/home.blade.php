<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mi legyen az ebéd?</title>
</head>
<body>

@if( auth()->check() )
    <a href="{{url('logout')}}">Logout</a><br><br>
    {{$date}}

    @foreach($dishes as $dish)
        <div>{{ htmlspecialchars($dish->dish_name)}}</div>
    @endforeach

@else
    <a href="{{url('register')}}">Registration</a><br>
    <a href="{{url('login')}}">Login</a><br><br>
    <div> Log in to see the menu!</div>

@endif

</body>
</html>
