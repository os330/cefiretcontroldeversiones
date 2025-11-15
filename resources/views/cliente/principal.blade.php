<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Centro de Rehabilitación y Fisioterapia</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../css/principal.css">
</head>

<body>
  <div class="container">

    <div class="header">
      <img src="../img/logo.jpg" alt="Logo Cefiret">
      <div class="titulo">
        <h2>CENTRO DE FISIOTERAPIA Y REHABILITACIÓN</h2>
      </div>
    </div>

<nav class="navbar navbar-expand-lg navbar-light bg-white border rounded shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold me-5" href="principal.html">CEFIRET</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarContent" aria-controls="navbarContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link fw-bold" href="principal.html">Inicio</a>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-bold" href="#">CEFIRET</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown"
            role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Servicios
          </a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="usuarios.html">Registrar usuario</a></li>
            <li><a class="dropdown-item" href="buscarU.html">Actualizar datos</a></li>
            <li><a class="dropdown-item" href="buscarE.html">Consultar expediente</a></li>
            <li><a class="dropdown-item" href="rutinas.html">Rutinas</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="d-flex ms-auto">
      <a href="../index.html" class="btn btn-outline-danger fw-bold">Salir</a>
    </div>
  </div>
</nav>

    <div class="main-content">
      <header>
        <h1>Cefiret</h1>
        <h3>Bienvenido:</h3>
      </header>

      <div class="contenido">
        <div class="columna">
          <img src="../img/1.jpg" alt="Lumbalgia">
          <p>La lumbalgia crónica sería aquella que se prolonga más allá de 3 meses.</p>
        </div>

        <div class="columna">
          <p>Los problemas lumbares están aumentando entre la población española adulta, y esto es causado en parte por un empeoramiento de nuestras prácticas posturales, tanto en el trabajo como durante el descanso, y por nuestro creciente sedentarismo, lo que disminuye nuestra flexibilidad general, además de debilitar nuestro sistema músculo-esquelético.</p>
          <img src="../img/2.jpg" alt="Dolor lumbar">
        </div>
      </div>

      <footer>
        <p>© 2025 CEFIRET. Todos los derechos reservados.  
           Autores: Oscar Chavez Villada y Jetsibee Gutierrez Ramirez</p>
      </footer>

    </div>
  </div>
</body>
</html>
