<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h1 style="color: #333; text-align: center;">Código de Verificación</h1>
        <p style="color: #666; font-size: 16px; line-height: 1.5;">
            Hola,
        </p>
        <p style="color: #666; font-size: 16px; line-height: 1.5;">
            Has solicitado registrarte como Guía Turístico en WORLD TRAVELS. Para completar tu registro, utiliza el siguiente código de verificación:
        </p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="display: inline-block; background-color: #007bff; color: #ffffff; font-size: 24px; font-weight: bold; padding: 15px 30px; border-radius: 5px; letter-spacing: 2px;">
                {{ $codigo }}
            </span>
        </div>
        <p style="color: #666; font-size: 16px; line-height: 1.5;">
            Este código es válido por 24 horas. Si no solicitaste este registro, ignora este mensaje.
        </p>
        <p style="color: #666; font-size: 16px; line-height: 1.5;">
            Gracias por unirte a WORLD TRAVELS.
        </p>
        <p style="color: #666; font-size: 16px; line-height: 1.5;">
            Atentamente,<br>
            El equipo de WORLD TRAVELS
        </p>
    </div>
</body>
</html>