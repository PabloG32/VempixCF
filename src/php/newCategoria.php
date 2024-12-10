<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/Logo.png" type="image/jpeg">
    <title>VempixCF</title>
    <link rel="stylesheet" href="../css/productos.css">
</head>

<body>
    <form class="form-registro" action="controller.php?operacion=crearC" method="post" enctype="multipart/form-data">
        <h1 class="title">Creación de una nueva categoria</h1>
        <div class="form-group">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-input" name="nombre" id="nombre" placeholder="Escribe el nombre" maxlength="50" required>
        </div>
        <input type="submit" value="Crear" class="form-submit" name="crearC">
        <button onclick="window.location.href='../php/tienda.php';">Volver al inicio</button>
    </form>
</body>

</html>