<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>

    <style>
        body {
            background: #f3f3f3;
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .contenedor {
            background: #fff;
            width: 350px;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #c3c3c3;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #bbb;
        }
        button {
            width: 100%;
            background: #1171b8;
            color: white;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-top: 10px;
            cursor: pointer;
        }
        button:hover { background: #0f5f9e; }
        .error { color: red; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Iniciar Sesión</h2>

    <form action="{{ route('login.validar') }}" method="POST">
        @csrf
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Entrar</button>
    </form>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif
</div>

</body>
</html>
