@php
    $errors = session('errors') ?? new \Illuminate\Support\ViewErrorBag();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>
</head>

<body>
    <h1>Hi Now If You are registered please Log in here: Please go Ahead::👇</h1>
    <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <input type="email" name="email" id="" placeholder="Enter your Email">
        <input type="password" name="password" id="" placeholder="Enter your Password">
        <button type="submit">Log In</button>
    </form>
    <h2>Don't have an account? <a href="{{ route('signup') }}">Sign up</a></h2>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</body>

</html>
