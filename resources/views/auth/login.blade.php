<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion au Dashboard</title>
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
          <h1>Espace de connexion</h1>
          @if(session('error_msg'))
          <div class="alert alert-danger" style="color: rgb(215, 88, 88); font-weight: bold">{{ session('error_msg') }}</div>
          @endif
          <p class="subtitle">Connectez-vous pour accéder à votre espace</p>
        </div>

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" class="input-field" placeholder="nom@exemple.com" required>
        </div>

        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" class="input-field" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn">Connexion</button>
      </div>
    </form>
  </div>
</body>
</html>
