<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Clientes</title>

<style>
body {
    font-family: Arial;
    background: #f2f2f2;
}
.tabla {
    width: 90%;
    margin: 30px auto;
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0px 0px 8px #aaa;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}
th { background: #007bff; color: white; }
a.boton {
    padding: 8px 12px;
    text-decoration: none;
    background: #28a745;
    color: white;
    border-radius: 5px;
}
.boton:hover { background: #1e7e34; }
</style>

</head>
<body>

<div class="tabla">
    <h2>Lista de Clientes</h2>

    <a class="boton" href="{{ route('clientes.crear') }}">Agregar Cliente</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $c)
            <tr>
                <td>{{ $c->idusuario }}</td>
                <td>{{ $c->nombre }}</td>
                <td>{{ $c->correo }}</td>
                <td>{{ $c->telefono }}</td>
                <td>
                    <a href="{{ route('clientes.editar', $c->idusuario) }}">Editar</a> |
                    <a href="{{ route('clientes.eliminar', $c->idusuario) }}">Eliminar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>
