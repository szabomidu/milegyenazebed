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
<form method="POST" action='/login'>
    @csrf
    <label for="name">Username
        <input id="name" type="text" name="name" required>
    </label>

    <label for="password"> Password
        <input id="password" type="password" name="password" required>
    </label>
    <input type="submit" value="Login">
</form>

@foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach

</body>
</html>
