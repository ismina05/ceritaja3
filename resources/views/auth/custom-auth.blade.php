<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Login / Register</title>
		
		<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
	</head>
	<body>
		<div class="container">
			<!-- Login Form -->
			<div class="form-box login">
				<form method="POST" action="/login">
                    @csrf
					<h1>Login</h1>
					<div class="input-box">
						<input type="email" name="email" placeholder="Email" required>
						<i class="fa-solid fa-envelope"></i>
					</div>
					<div class="input-box">
						<input type="password" name="password" placeholder="Password" required>
						<i class="fa-solid fa-lock"></i>
					</div>
					<div class="input-box">
						<input type="password" name="password_confirmation" placeholder="Confirm Password" required>
						<i class="fa-solid fa-lock"></i>
					</div>
                    <!-- ERROR -->
                    @if ($errors->any())
                        <p class="error">{{ $errors->first() }}</p>
                    @endif

					<div class="forgot-link">
						<a href="{{ route('password.request') }}">Forgot Password?</a>
					</div>
					<button type="submit" class="btn">Login</button>
					<p>or login with social platforms</p>
					<div class="social-icons">
						<a href="#" class="coming-soon"><i class="fa-brands fa-google"></i></a>
						<a href="#" class="coming-soon"><i class="fa-brands fa-facebook-f"></i></a>
						<a href="#" class="coming-soon"><i class="fa-brands fa-github"></i></a>
						<a href="#" class="coming-soon"><i class="fa-brands fa-linkedin-in"></i></a>
					</div>
				</form>
			</div>

			@if ($errors->any())
				<p class="error">{{ $errors->first() }}</p>
			@endif

			<button type="submit" class="btn">Register</button>
			
			<!-- Register Form -->
			<div class="form-box register">
				<form method="POST" action="/register">
                    @csrf
					<h1>Registration</h1>
					<div class="input-box">
						<input type="text" name="name" placeholder="Username" required>
						<i class="fa-solid fa-user"></i>
					</div>
					<div class="input-box">
						<input type="email" name="email" placeholder="Email" required>
						<i class="fa-solid fa-envelope"></i>
					</div>
					<div class="input-box">
						<input type="password" name="password" placeholder="Password" required>
						<i class="fa-solid fa-lock"></i>
					</div>
					<button type="submit" class="btn">Register</button>
					<p>or register with social platforms</p>
					<div class="social-icons">
						<a href="#" class="coming-soon"><i class="fa-brands fa-google"></i></a>
						<a href="#" class="coming-soon"><i class="fa-brands fa-facebook-f"></i></a>
						<a href="#" class="coming-soon"><i class="fa-brands fa-github"></i></a>
						<a href="#" class="coming-soon"><i class="fa-brands fa-linkedin-in"></i></a>
					</div>
				</form>
			</div>
			
			
			<!-- Toggle Box -->
			<div class="toggle-box">
				<!-- Toggle Box Left -->
				<div class="toggle-panel toggle-left">
					<h1>Hello, Welcome!</h1>
					<p>Don't have an account?</p>
					<button class="btn register-btn">Register</button>
				</div>
				
				<!-- Toggle Box Right -->
				<div class="toggle-panel toggle-right">
					<h1>Welcome Back!</h1>
					<p>Already have an account?</p>
					<button class="btn login-btn">Login</button>
				</div>
			</div>
		</div>
	</body>
	<script src="{{ asset('js/script.js') }}"></script>
</html>