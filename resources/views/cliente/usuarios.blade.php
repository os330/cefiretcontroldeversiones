<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro de Usuario</title>

  <link rel="stylesheet" href="../css/estiloPrincipal.css">
</head>
<body>

<div class="main-content">
  <header>
    <h1>Registro de Usuario</h1>
  </header>

  <div class="content">
    <form class="formulario" id="formRegistro">

      <h2>Registro de Usuario</h2>

      <div class="fila">
        <input type="text" placeholder="Nombre(s)" required>
        <input type="text" placeholder="Apellido Paterno" required>
      </div>

      <div class="fila">
        <input type="text" placeholder="Apellido Materno" required>
        <input type="date" required>
      </div>

      <div class="fila">
        <input type="email" placeholder="Correo Electrónico" required>
        <input type="tel" placeholder="Teléfono (10 dígitos)" required>
      </div>

      <div class="fila">
        <input type="password" placeholder="Contraseña" required>
        <select required>
          <option value="">Selecciona tipo de usuario</option>
          <option value="1">Administrador</option>
          <option value="2">Fisioterapeuta</option>
          <option value="3">Paciente</option>
        </select>
      </div>

      <div class="acciones">
        <button type="submit" disabled>Registrar</button>
        <button type="button" class="cancelar-btn" onclick="window.location.href='principal.html'">
          Cancelar
        </button>
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
