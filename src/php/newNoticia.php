<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/Logo.jpeg" type="image/jpeg">
    <title>Añadir una noticia</title>
    <link rel="stylesheet" href="../css/productos.css">
</head>

<body>
    <form class="form-registro" action="controller.php?operacion=crearN" method="post" enctype="multipart/form-data">
        <h1 class="title">Añadir una noticia</h1>
        <div class="form-group">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-input" name="titulo" id="titulo" placeholder="Escribe el titulo" maxlength="200" required>
        </div>
        <div class="form-group">
            <label for="contenido" class="form-label">Contenido</label>
            <input type="text" class="form-input" name="contenido" id="contenido" placeholder="Escribe el contenido" maxlength="255" required>
        </div>
        <div class="form-group">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" step="0.01" class="form-input" name="fecha" id="fecha" placeholder="Escribe el precio" required>
        </div>
        <div class="form-group">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-file" name="imagen" id="imagen" required>
        </div>
        <input type="submit" value="Crear" class="form-submit" name="crear">
        <button onclick="window.location.href='../php/tienda.php';">Volver al inicio</button>
    </form>
</body>

</html>