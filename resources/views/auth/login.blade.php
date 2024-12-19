<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>

    <h1>Connexion</h1>

    <!-- Affichage des erreurs -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de connexion -->
    <form action="{{ route('login.submit') }}" method="POST">
        @csrf

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        <br><br>

        <label for="mdp">Mot de passe:</label>
        <input type="password" id="mdp" name="mdp" required>
        <br><br>

        <button type="submit">Se connecter</button>
    </form>

</body>
</html>
