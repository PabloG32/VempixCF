<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Añadir nuevo producto</title>
    <link rel="stylesheet" href="../css/productos.css">
</head>

<body>
    <?php
    require_once 'libreriaPDO.php';
    $db = new DB("vempixcf");
    $cat = "";

    if (isset($_POST['categoria'])) {
        $cat = $_POST['categoria'];
    }
    ?>
    <form class="form-registro" action="controller.php?operacion=crear" method="post" enctype="multipart/form-data">
        <h1 class="title">Creación de un nuevo producto</h1>
        <div class="form-group">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-input" name="nombre" id="nombre" placeholder="Escribe el nombre" maxlength="50" required>
        </div>
        <div class="form-group">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-input" name="descripcion" id="descripcion" placeholder="Escribe la descripcion" maxlength="100" required>
        </div>
        <div class="form-group">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-input" name="precio" id="precio" placeholder="Escribe el precio" required>
        </div>
        <div class="form-group">
            <label for="categoria" class="form-label">Categoria</label>
            <select name='categoria'>
                <option value=""></option>
                <?php
                $param = array();
                $consulta = "select id, nombre from categorias";
                $db->ConsultaDatos($consulta, $param);
                foreach ($db->filas as $fila) {
                    echo "<option value=$fila[id] ";
                    if ($cat == $fila['id']) {
                        echo " selected ";
                    }
                    echo "> $fila[nombre]</option>";
                }
                ?>
            </select>

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