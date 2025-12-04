<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('titulo')</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header{
            background: #0062cc;
            color: white;
            padding: 15px;
        }
        .contenedor{
            width: 90%;
            margin: auto;
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
        }
        a{
            text-decoration: none;
            color: #0062cc;
            font-weight: bold;
        }
        .btn{
            background: #0062cc;
            padding: 8px 15px;
            border-radius: 5px;
            color: white !important;
        }
        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td{
            padding: 10px;
            border: 1px solid #ddd;
        }
        form{
            margin-top: 15px;
        }
        input, select, textarea{
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            border: 1px solid #aaa;
            border-radius: 5px;
        }
        .acciones a{
            margin-right: 7px;
        }
    </style>
</head>
<body>

<header>
    <h2>CEFIRET - Sistema</h2>
</header>

<div class="contenedor">
    @yield('contenido')
</div>

</body>
</html>
