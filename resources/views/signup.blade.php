@php
    $errors = session('errors') ?? new \Illuminate\Support\ViewErrorBag();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form</title>
</head>

<body>
    <h1>Hi U can sign up here: Please go Ahead::👇</h1>
    <form action="{{ route('signup.store') }}" method="POST">
        @csrf
        <input type="text" name="name" id="" placeholder="Enter your Name:">
        <input type="email" name="email" id="" placeholder="Enter your Email">
        <input type="password" name="password" id="" placeholder="Enter your Password">
        <input type="password" name="password_confirmation" id="" placeholder="Password Again">
        <button type="submit">Sign Up</button>
    </form>
    <h2>Already have an account? <a href="{{ route('login') }}">Log in</a></h2>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</body>

</html>
