<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .button {
            display: inline-block;
            background-color: #28a745;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>World Travels</h1>
            <h2>Restablecer Contraseña</h2>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Has solicitado restablecer tu contraseña. Haz clic en el botón de abajo para continuar con el proceso:</p>
            <a href="{{ url('/reset-password?token=' . $token . '&email=' . urlencode($email)) }}" class="button">Restablecer Contraseña</a>
            <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
            <p>Este enlace expirará en 60 minutos por razones de seguridad.</p>
        </div>
        <div class="footer">
            <p>Si tienes problemas con el botón, copia y pega esta URL en tu navegador:</p>
            <p>{{ url('/reset-password?token=' . $token . '&email=' . urlencode($email)) }}</p>
            <p>&copy; 2025 World Travels. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>