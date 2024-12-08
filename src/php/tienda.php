<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  // Redirigir al login si no hay una sesión activa
  header("Location: ../html/index.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../img/Logo.jpeg" type="image/jpeg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Actualiza los datos del json
      fetch('../php/DaoDatos.php')
        .then(response => {
          if (!response.ok) {
            throw new Error("Error en la respuesta del servidor: " + response.statusText);
          }
          return response.text();
        })
        .then(data => {
          console.log("Archivo PHP ejecutado:", data);
        })
        .catch(error => console.error("Error al ejecutar el archivo PHP:", error));
    });
  </script>
  <link rel="stylesheet" href="../css/product.css">
  <link rel="stylesheet" href="../css/infoproducto.css">
  <title>VempixCF</title>
</head>

<body>
  <!-- Barra de navegacion -->
  <div class="container-xl">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a id="init" href="tienda.php"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <img class="bi me-2" src="../img/Logo.jpeg" alt="" width="40" height="32">
        <span class="fs-4 link-light">VempixCF</span>
      </a>

      <ul class="nav nav-pills" id="nav-menu">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle link-light" href="#" data-bs-toggle="dropdown" aria-expanded="false">Categorias</a>
          <ul class="dropdown-menu" id="cat-menu">

          </ul>
        </li>
        <li class="nav-item">
          <a id="carrito" class=" nav-link link-light text-decoration-none" href="../php/accionesCarrito.php?accion=ver"><i class="fa-solid fa-cart-shopping"></i></a>
        </li>

        <?php
        if ($_SESSION['rol'] === 0) {
          echo "<li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle link-light' href='#' id='adminMenu' role='button' data-bs-toggle='dropdown' aria-expanded='false'>Adminitración</a>
          <ul class='dropdown-menu'>
          <li><a id='newProducto' class='dropdown-item' href='#'>Productos</a></li>
          <li><a id='newCategoria' class='dropdown-item' href='#'>Categorias</a></li>
          </ul>
        </li>
        ";
        }
        ?>
      </ul>
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a id="cerrar" class="nav-link link-light" href="../php/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        </li>
      </ul>
    </header>
  </div>

  <main>

    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>

    <!-- Carrusel -->
    <div id="imageCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="../img/cinturon.jpeg" class="d-block w-50 mx-auto" alt="Imagen 1">
          <div class="carousel-caption d-none d-md-block">
            <h5 class="text-dark">Bienvenidos a VempixCF</h5>
            <p class="text-dark">Descubre las mejores ofertas y productos.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../img/barra.jpg" class="d-block w-50 mx-auto" alt="Imagen 2">
          <div class="carousel-caption d-none d-md-block">
            <h5 class="text-dark">Novedades</h5>
            <p class="text-dark">Encuentra los últimos productos de CrossFit.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../img/rodilleras.jpeg" class="d-block w-50 mx-auto" alt="Imagen 3">
          <div class="carousel-caption d-none d-md-block">
            <h5 class="text-dark">Descuentos increíbles</h5>
            <p class="text-dark">Aprovecha nuestras ofertas de temporada.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>

    <!--Productos centro-->
    <div class="album py-5">
      <h2 class="display-5 fw-bold text-center">Productos</h2>
      <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="productos-centro">
          <div class="d-flex justify-content-between align-items-center">

          </div>
        </div>
      </div>
    </div>

  </main>

  <!-- Footer -->
  <footer class="container-xl py-5">
    <div class="row">
      <div class="col-6 col-md-2 mb-3">
        <h5>Conócenos</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 link-light">Sobre nosotros</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 link-light">Envíos y devoluciones</a></li>
        </ul>
      </div>

      <div class="col-6 col-md-2 mb-3">
        <h5>Legal</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 link-light">Política de privacidad</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 link-light">Aviso Legal</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 link-light">Términos y condiciones</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 link-light">Condiciones de Uso y Compra</a>
          </li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 link-light">Politica de Cookies</a></li>
        </ul>
      </div>

      <div class="col-6 col-md-2 mb-3">
        <h5>Contacto</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 link-light">Llámanos al +34 666 666 666</a>
          </li>
          <li class="nav-item mb-2"><a href="#"
              class="nav-link p-0 link-light">soporte.cliente@vempixcf.com</a></li>
        </ul>
      </div>

      <div class="col-md-5 offset-md-1 mb-3">
        <form>
          <h5>Suscríbete a nuestro boletín de noticias.</h5>
          <p>Resumen mensual de lo nuevo y noticias, aparte recibe un 10% de descuento para tus compras.</p>
          <div class="d-flex flex-column flex-sm-row w-100 gap-2">
            <label for="newsletter1" class="visually-hidden">Email address</label>
            <input id="newsletter1" type="text" class="form-control" placeholder="Dirección de correo">
            <button class="btn btn-primary" type="button">Suscribir</button>
          </div>
        </form>
      </div>
    </div>

    <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
      <p>&copy; 2024 VempixCF, Inc. All rights reserved.</p>
      <ul class="list-unstyled d-flex">
        <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#twitter" />
            </svg></a></li>
        <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#instagram" />
            </svg></a></li>
        <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#facebook" />
            </svg></a></li>
      </ul>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script type="module" src="../js/VempixcfApp.js"></script>
  <script src="https://kit.fontawesome.com/78f5e35a11.js" crossorigin="anonymous"></script>
</body>

</html>