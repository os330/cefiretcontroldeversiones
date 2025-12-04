@extends('layout.plantilla')

@section('titulo', 'Clientes')

@section('contenido')

<h2>Lista de Clientes</h2>

<!-- Botón para crear cliente -->
<a class="btn" href="{{ route('clientes.crear') }}">Agregar Cliente</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre completo</th>
            <th>Fecha nacimiento</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $c)
        <tr>
            <td>{{ $c->id_usuario }}</td>
            <td>{{ $c->nombre }} {{ $c->apaterno }} {{ $c->amaterno }}</td>
            <td>{{ $c->fecha_nac }}</td>
            <td>{{ $c->telefono }}</td>
            <td>{{ $c->correo }}</td>
            <td>
                @if(isset($c->id_tipo_usuario))
                    {{ $c->id_tipo_usuario }}
                @else
                    -
                @endif
            </td>
            <td class="acciones">
                <a href="{{ route('clientes.editar', $c->id_usuario) }}">Editar</a>
                <a href="{{ route('clientes.eliminar', $c->id_usuario) }}" onclick="return confirm('¿Eliminar cliente?')">Eliminar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
