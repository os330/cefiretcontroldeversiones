<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro en CEFIRET</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .contenedor {
            background: #ffffff;
            width: 90%;
            max-width: 650px;
            margin: 25px auto;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        h2 {
            color: #2a5da8;
            margin-bottom: 10px;
        }
        p {
            font-size: 15px;
            line-height: 1.5;
            color: #333;
        }
        .footer {
            margin-top: 25px;
            font-size: 13px;
            color: #777;
            text-align: center;
        }
        .resaltado {
            font-weight: bold;
            color: #2a5da8;
        }
    </style>
</head>
<body>

    <div class="contenedor">
        <h2>Ha sido registrado en CEFIRET</h2>

        <p>Hola <span class="resaltado">{{ $nombreCompleto }}</span>,</p>

        <p>
            Le informamos que su cuenta ha sido registrada exitosamente 
            en el <strong>Centro de Fisioterapia y Rehabilitación CEFIRET</strong>.
        </p>

        <p>
            A partir de ahora podrá acceder al sistema utilizando su correo registrado:
        </p>

        <p class="resaltado">{{ $correo }}</p>

        <p>
            Nuestro equipo le dará acceso a la aplicación que contiene ejercicios de rehabilitación 
            y seguimiento de su progreso.
        </p>

        <div class="footer">
            Que tenga un excelente dia y gracias por confiar en CEFIRET.
        </div>
    </div>

</body>
</html>
