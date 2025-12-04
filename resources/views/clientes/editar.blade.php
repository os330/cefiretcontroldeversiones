@extends('layouts.plantilla')

@section('titulo', 'Editar Cliente')

@section('contenido')

<h2>Editar Cliente</h2>

<form action="{{ route('clientes.actualizar', $cliente->id_usuario) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nombre:</label>
    <input type="text" name="nombre" value="{{ $cliente->nombre }}" required>

    <label>Apellido paterno:</label>
    <input type="text" name="apaterno" value="{{ $cliente->apaterno }}">

    <label>Apellido materno:</label>
    <input type="text" name="amaterno" value="{{ $cliente->amaterno }}">

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nac" value="{{ $cliente->fecha_nac }}">

    <label>Teléfono:</label>
    <input type="text" name="telefono" value="{{ $cliente->telefono }}">

    <label>Correo:</label>
    <input type="email" name="correo" value="{{ $cliente->correo }}" required>

    <label>Contraseña (dejar en blanco para no cambiar):</label>
    <input type="password" name="contrasena">

    <label>Tipo de usuario:</label>
    <select name="id_tipo_usuario" required>
        <option value="1" {{ $cliente->id_tipo_usuario == 1 ? 'selected' : '' }}>Administrador</option>
        <option value="2" {{ $cliente->id_tipo_usuario == 2 ? 'selected' : '' }}>Fisioterapeuta</option>
        <option value="3" {{ $cliente->id_tipo_usuario == 3 ? 'selected' : '' }}>Paciente</option>
    </select>

    <button class="btn" type="submit">Actualizar Cliente</button>
</form>

@endsection
