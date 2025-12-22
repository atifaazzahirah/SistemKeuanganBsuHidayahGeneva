<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bank Sampah Hidayah Geneva</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="container">
    <div class="title">Bank Sampah Hidayah Geneva</div>

    <div class="card">
        <h2>MASUK</h2>

        @if($errors->any())
            <div class="alert">Email atau password salah!</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <!-- Lupa Password -->
            <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>

            <button type="submit" class="btn">Masuk</button>
        </form>

    </div>
</div>

</body>
</html>
