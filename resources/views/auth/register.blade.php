<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Account</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="container">
    <form method="post" action="{{route('handleRegister')}}">
      @csrf
      <div class="card">
        <div class="logo">
          <div class="logo-circle">D</div>
          <h1>Create Account</h1>
          @if ($errors->any())
            <div class="alert alert-danger" style="color: rgb(215, 88, 88); font-weight: bold">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <p class="subtitle">Sign up to access the dashboard</p>
        </div>
        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" class="input-field" placeholder="John Doe" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" id="email" name="email" class="input-field" placeholder="name@example.com" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="input-field" placeholder="••••••••" required>
        </div>
        <div class="form-group">
          <label for="password_confirmation">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn">Register</button>
        <p class="register-link">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
      </div>
    </form>
  </div>
</body>
</html>
