<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Event Planner</title>
</head>

<body>
    <h1>Welcome to Event Planner</h1>
    <div>
        <a href="{{ route('signup') }}">Sign Up</a>
        <a href="{{ route('login') }}">Login</a>
    </div>
</body>

</html>
