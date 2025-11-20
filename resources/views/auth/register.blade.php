<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bank Sampah Hidayah Geneva</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="container">
    <div class="title">Bank Sampah Hidayah Geneva</div>

    <div class="card">
        <h2>REGISTER</h2>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert">Silakan perbaiki data berikut:</div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Username -->
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="Username" value="{{ old('Username') }}" required autofocus>
                @error('Username') <span class="error">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="Email" value="{{ old('Email') }}" required>
                @error('Email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="Password" required>
                @error('Password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn">Register</button>
        </form>

        <p class="register-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
</div>

</body>
</html>