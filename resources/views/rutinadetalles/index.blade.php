@extends('layouts.plantilla')

@section('titulo', 'Detalles de Rutina')

@section('contenido')

<h2>Detalles de Rutina</h2>

<a class="btn" href="{{ route('rutinadetalles.crear') }}">Agregar Detalle</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Rutina</th>
            <th>Ejercicio</th>
            <th>Repeticiones</th>
            <th>Series</th>
            <th>Tiempo (seg)</th>
            <th>Orden</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($detalles as $d)
        <tr>
            <td>{{ $d->id_detalle }}</td>
            <td>{{ $d->rutina }}</td>
            <td>{{ $d->ejercicio }}</td>
            <td>{{ $d->repeticiones }}</td>
            <td>{{ $d->series }}</td>
            <td>{{ $d->tiempo }}</td>
            <td>{{ $d->orden }}</td>

            <td class="acciones">
                <a href="{{ route('rutinadetalles.editar', $d->id_detalle) }}">Editar</a>
                <a href="{{ route('rutinadetalles.eliminar', $d->id_detalle) }}"
                   onclick="return confirm('¿Eliminar detalle?')">
                    Eliminar
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
