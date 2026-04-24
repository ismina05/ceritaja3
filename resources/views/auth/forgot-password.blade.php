<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <div class="form-box login" style="width:100%;">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <h1>Reset Password</h1>
                <p>Enter your email address and we'll send you a link to reset your password.</p>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                @if (session('status'))
                    <p style="color:green;">{{ session('status') }}</p>
                @endif
                <!-- ERROR -->
                @if ($errors->any())
                    <p style="color:red;">{{ $errors->first() }}</p>
                @endif

                <button type="submit" class="btn">Email Password Reset Link</button>
                <p>
                    <a href="/auth">Back to Login</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>