<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha Agrobov</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding: 10px 0;
        }
        .email-header img {
            max-width: 150px;
            height: auto;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-body a {
            display: inline-block;
            background-color: #28a745;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }
        .email-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ $message->embed(public_path('/logotcc.jpeg')) }}" alt="Agrobov Logo">
        </div>
        <div class="email-body">
            <h1>Redefinir Senha Agrobov</h1>
            <p>Você solicitou a redefinição de sua senha no site Agrobov. Clique no link abaixo para redefinir sua senha:</p>
            <a href="{{ $resetLink }}">Redefinir Senha</a>
            <p>Se você não solicitou esta redefinição, por favor, ignore este e-mail.</p>
        </div>
        <div class="email-footer">
            <p>&copy; 2024 Agrobov. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
