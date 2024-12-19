<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code PIN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .header {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .code {
            font-size: 30px;
            font-weight: bold;
            color: #007bff;
            background-color: #f0f8ff;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
        }

        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 30px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Bonjour,
        </div>
        <div class="message">
            Nous avons reçu une demande de connexion à votre compte. Veuillez utiliser le code PIN ci-dessous pour compléter le processus de vérification :
        </div>
        <div class="code">
            {{ $pin }}
        </div>
    </div>
</body>
</html>
