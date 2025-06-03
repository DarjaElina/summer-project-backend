<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Event Planner</title>
</head>

<body>
    <h1>This is our Summer Project Backend ☀️</h1>
    <a href="{{ route('signup') }}">Sign UP</a><br>
    <a href="{{ route('login') }}">Login</a>
</body>

</html>
