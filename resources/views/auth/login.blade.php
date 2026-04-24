<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CeritAja</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="auth-bg">
    <div class="auth-card auth-card--login">

        {{-- KIRI: Panel ungu --}}
        <div class="auth-panel-side">
            <div class="auth-panel-content">
                <h2 class="panel-title">Hello, Welcome!</h2>
                <p class="panel-desc">Don't have an account?</p>
                <a href="{{ route('register') }}" class="btn-outline">Register</a>
            </div>
        </div>

        {{-- KANAN: Form Login --}}
        <div class="auth-form-side">
            <h2 class="auth-title">Login</h2>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="Email"
                            value="{{ old('email') }}" required autofocus>
                        <i class='bx bx-envelope input-icon'></i>
                    </div>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class='bx bx-lock input-icon'></i>
                    </div>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary">Login</button>
            </form>

            <div class="social-login">
                <p class="social-login-text">or login with social platforms</p>
                <div class="social-buttons">
                    <a href="#" class="social-btn"><i class='bx bxl-google'></i></a>
                    <a href="#" class="social-btn"><i class='bx bxl-facebook'></i></a>
                    <a href="#" class="social-btn"><i class='bx bxl-github'></i></a>
                    <a href="#" class="social-btn"><i class='bx bxl-linkedin'></i></a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>