@php
    $errors = session('errors') ?? new \Illuminate\Support\ViewErrorBag();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign_UP_Form</title>
</head>

<body>
    <h1>Hi U can sign up here: Please go Ahead::👇</h1>
    <form action="{{ route('signup') }}" method="POST">
        @csrf
        <input type="text" name="name" id="" placeholder="Enter your Name:">
        <input type="text" name="email" id="" placeholder="Enter your Email">
        <input type="text" name="password" id="" placeholder="Enter your Password">
        <input type="text" name="password_confirmation" id="" placeholder="Password Again">
        <button type="submit">Sign Up</button>
    </form>
    {{-- <h2>already have account <a href="{{ route('login') }}">Log in</a></h2> --}}
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

</body>

</html>
