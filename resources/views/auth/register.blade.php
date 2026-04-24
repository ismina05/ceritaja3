<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CeritAja</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="auth-bg">
    <div class="auth-card">

        {{-- KIRI: Form Register --}}
        <div class="auth-form-side">
            <h2 class="auth-title">Registration</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" name="name" placeholder="Username"
                            value="{{ old('name') }}" required autofocus>
                        <i class='bx bx-user input-icon'></i>
                    </div>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="Email"
                            value="{{ old('email') }}" required>
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

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation"
                            placeholder="Confirm Password" required>
                        <i class='bx bx-lock-alt input-icon'></i>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Register</button>
            </form>

            <div class="social-login">
                <p class="social-login-text">or register with social platforms</p>
                <div class="social-buttons">
                    <a href="#" class="social-btn"><i class='bx bxl-google'></i></a>
                    <a href="#" class="social-btn"><i class='bx bxl-facebook'></i></a>
                    <a href="#" class="social-btn"><i class='bx bxl-github'></i></a>
                    <a href="#" class="social-btn"><i class='bx bxl-linkedin'></i></a>
                </div>
            </div>
        </div>

        {{-- KANAN: Panel ungu --}}
        <div class="auth-panel-side">
            <div class="auth-panel-content">
                <h2 class="panel-title">Welcome Back!</h2>
                <p class="panel-desc">Already have an account?</p>
                <a href="{{ route('login') }}" class="btn-outline">Login</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>