<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @if(session('success'))
        <div style="color:green">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div>
            <label>First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}">
            @error('first_name')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

          <div>
            <label>Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}">
            @error('last_name')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password_hash">
            @error('password')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit">User</button>
    </form>


</body>

</html>