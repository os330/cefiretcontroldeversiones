<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar Sesión - Cefiret</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #b6dce7;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      padding: 2rem;
      max-width: 400px;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="card shadow-lg rounded text-center">
    <img src="img/logo.jpg" alt="Logo Cefiret" class="mx-auto mb-3" style="max-width: 120px;">
    <h4 class="mb-3">Iniciar Sesión</h4>

    <form id="loginForm">
      <div class="mb-3 text-start">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo">
      </div>

      <div class="mb-3 text-start">
        <label for="contra" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contra" name="contra">
      </div>

      <a href="/ce_maquetado/cliente/principal.html" class="btn btn-primary w-100">Iniciar Sesión</a>

      <div class="mt-3">
        <a href="#">¿Olvidaste tu contraseña?</a>
      </div>
    </form>
  </div>
</body>
</html>
