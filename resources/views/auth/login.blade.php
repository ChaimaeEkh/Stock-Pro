<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="container">
    <form method="post" action="{{route('handleLogin')}}">
      @csrf
      @method('POST')
      <div class="card">
        <div class="logo">
          <div class="logo-circle">D</div>
          <h1>Login Portal</h1>
          @if(session('error_msg'))
          <div class="alert alert-danger" style="color: rgb(215, 88, 88); font-weight: bold">{{ session('error_msg') }}</div>
          @endif
          @if(session('success'))
          <div class="alert alert-success" style="color: rgb(75, 181, 67); font-weight: bold">{{ session('success') }}</div>
          @endif
          <p class="subtitle">Sign in to access your account</p>
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" id="email" name="email" class="input-field" placeholder="name@example.com" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="input-field" placeholder="••••••••" required>
        </div>
        <div class="form-group remember-me">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn">Login</button>
        <p class="register-link">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
      </div>
    </form>
  </div>
</body>
</html>
