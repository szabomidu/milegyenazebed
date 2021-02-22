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
@foreach($date as $d)
    {{$d}}

@endforeach
@foreach($menuData as $menuItem)
    <div>{{$menuItem}}</div>
@endforeach
</body>
</html>
