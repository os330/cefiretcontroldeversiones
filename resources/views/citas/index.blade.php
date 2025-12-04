@extends('layouts.plantilla')

@section('titulo', 'Citas')

@section('contenido')

<h2>Lista de Citas</h2>

<a class="btn" href="{{ route('citas.crear') }}">Crear Cita</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Fisioterapeuta</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estatus</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($citas as $c)
        <tr>
            <td>{{ $c->id_cita }}</td>
            <td>{{ $c->paciente }}</td>
            <td>{{ $c->fisioterapeuta }}</td>
            <td>{{ $c->fecha }}</td>
            <td>{{ $c->hora }}</td>
            <td>{{ $c->estatus }}</td>
            <td class="acciones">
                <a href="{{ route('citas.editar', $c->id_cita) }}">Editar</a>
                <a href="{{ route('citas.eliminar', $c->id_cita) }}"
                   onclick="return confirm('¿Eliminar cita?')">Eliminar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
