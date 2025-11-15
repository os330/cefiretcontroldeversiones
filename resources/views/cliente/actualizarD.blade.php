<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Usuario</title>
  <link rel="stylesheet" href="../css/estiloPrincipal.css" />
</head>
<body>
  <div class="main-content">
    <header>
      <h1>Actualizar datos</h1>
    </header>

    <div class="content">
      <form method="POST" class="formulario">
        <div class="fila">
          <input type="text" name="nombre" placeholder="Nombre" value="">
          <input type="text" name="apaterno" placeholder="Apellido Paterno" value="" >
        </div>

        <div class="fila">
          <input type="text" name="amaterno" placeholder="Apellido Materno" value="" >
          <input type="date" name="fecha_nac" value="" >
        </div>

        <div class="fila">
          <input type="tel" name="telefono" placeholder="Teléfono" value="" >
          <input type="email" name="correo" placeholder="Correo Electrónico" value="" >
        </div>

        <div class="fila">
          <input type="password" name="contrasena" placeholder="Contraseña" value="" >
          <select name="id_tipo_usuario" >
            <option value="">Selecciona tipo de usuario</option>
            <option value="1" >Administrador</option>
            <option value="2" >Fisioterapeuta</option>
            <option value="3" >Paciente</option>
          </select>
        </div>

        <div class="acciones">
          <button type="button" onclick="location.href='../cliente/buscarU.html'">Guardar cambios</button>    
            <button type="button" onclick="location.href='../cliente/buscarU.html'">Cancelar</button>

        </div>
      </form>   
    </div>
    <footer>
        <p>© 2025 CEFIRET. Todos los derechos reservados.  
           Autores: Oscar Chavez Villada y Jetsibee Gutierrez Ramirez</p>
      </footer>
  </div>
</body>
</html>
