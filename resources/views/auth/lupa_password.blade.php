<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="container">
    <div class="title">Lupa Password</div>

    <div class="card">
        <h2>RESET PASSWORD</h2>

        {{-- Sukses --}}
        @if(session('success'))
            <div class="alert" style="background:#d4f8d4; color:green;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error --}}
        @if(session('error'))
            <div class="alert" style="background:#ffd5d5; color:red;">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validasi --}}
        @if($errors->any())
            <div class="alert" style="background:#ffd5d5; color:red;">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('show_step2'))
        {{-- STEP 2: Masukkan Token & Password Baru --}}
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ session('email_reset') }}">

            <div class="form-group">
                <label>Kode Reset</label>
                <input type="text" name="token" required>
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn">Reset Password</button>
            <a href="{{ route('login') }}" class="forgot-link">Kembali ke Login</a>
        </form>
        @else
        {{-- STEP 1: Masukkan Email --}}
        <form action="{{ route('password.send') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Masukkan Email Anda</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <button type="submit" class="btn">Kirim Kode Reset</button>
            <a href="{{ route('login') }}" class="forgot-link">Kembali ke Login</a>
        </form>
        @endif

    </div>
</div>

</body>
</html>
