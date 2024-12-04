<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/Logo.jpeg" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Listado de productos</title>
    <style>
        body {
            background-image: url(../img/fondo_web.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
    </style>
</head>

<body>
    <?php
    require_once 'DaoProducto.php';
    $base = "vempixcf";
    $daoProd = new DaoProducto($base);

    if (isset($_POST['Borrar']) && isset($_POST['Selec'])) {
        $selec = $_POST['Selec']; //Recogemos los ids del los checkboxes seleccionados

        foreach ($selec as $clave => $valor) //Para cada uno de los productos seleccinados
        {
            $daoProd->Borrar($clave);  //Borramos la seleccion

        }
        echo "<script>window.location.href='./controller.php?operacion=listadoproductos';</script>";
        exit();
    }
    ?>
    <div class="d-flex justify-content-center align-items-center">
        <h1 class="display-5">Listado de productos</h1>
    </div>
    <div class="container mt-4">
        <form method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
            <table class="table">
                <tr>
                    <th class="table-dark">Seleccionar</th>
                    <th class="table-dark">Nombre</th>
                    <th class="table-dark">descripcion</th>
                    <th class="table-dark">Precio</th>
                    <th class="table-dark">Categoria</th>
                    <th class="table-dark">Imagen</th>
                </tr>
                <?php

                foreach ($productos as $producto) {
                    echo ("<tr class='table-primary'>");
                    echo ("<td class='table-primary'><input type='checkbox'  name='Selec[" . $producto->__get("id") . "]'></td>");
                    echo ("<td class='table-primary'>" . $producto->__get("nombre") . "</td>");
                    echo ("<td class='table-primary'>" . $producto->__get("descripcion") . "</td>");
                    echo ("<td class='table-primary'>" . $producto->__get("precio") . "</td>");
                    echo ("<td class='table-primary'>" . $producto->__get("categoria") . "</td>");
                    $imagenBase64 = base64_encode($producto->__get("imagen"));
                    echo "<td class='table-primary'><img src='data:image/jpeg;base64,$imagenBase64' width=100 height=100 ></td>";
                    echo ("</tr class='table-primary'>");
                }
                ?>
            </table>
            <div class="d-flex flex-column flex-md-row gap-2">
                <input type='submit' class="btn btn-danger mb-2 mb-md-0" name='Borrar' value='Borrar'>
                <button onclick="window.location.href='../php/tienda.php';" type="button" class="btn btn-primary">Volver al inicio</button>
            </div>
        </form>
    </div>
</body>

</html>