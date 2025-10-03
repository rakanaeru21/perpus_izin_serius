<!DOCTYPE html>
<html>
<head>
    <title>Test Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Registration Form</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <p>
            <label>Nama Lengkap:</label><br>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
        </p>
        <p>
            <label>Username:</label><br>
            <input type="text" name="username" value="{{ old('username') }}" required>
        </p>
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </p>
        <p>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </p>
        <p>
            <label>Confirm Password:</label><br>
            <input type="password" name="password_confirmation" required>
        </p>
        <p>
            <label>
                <input type="checkbox" name="terms" value="1" required>
                I agree to terms
            </label>
        </p>
        <p>
            <button type="submit">Register</button>
        </p>
    </form>
</body>
</html>
