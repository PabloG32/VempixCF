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

    if (isset($_POST['Borrar']) && isset($_POST['Selec']))  //Si hemos seleccionado algun producto y pulsado borrar
    {
        $selec = $_POST['Selec']; //Recogemos los ids del los checkboxes seleccionados

        foreach ($selec as $clave => $valor) //Para cada uno de los productos seleccinados
        {
            $daoProd->Borrar($clave);  //Borramos la seleccion

        }
        header("Location: controller.php?operacion=listadoproductos");
        exit();
    }
    ?>
    <div class="d-flex justify-content-center align-items-center">
        <h1 class="display-5">Listado de productos</h1>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <form action="" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
                    <table class="table">
                        <tr>
                            <th scope="col">Seleccionar</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">descripcion</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Imagen</th>
                        </tr>
                        <?php

                        foreach ($productos as $producto) {
                            echo ("<tr>");
                            echo ("<td><input type='checkbox'  name='Selec[" . $producto->__get("id") . "]'></td>");
                            echo ("<td>" . $producto->__get("nombre") . "</td>");
                            echo ("<td>" . $producto->__get("descripcion") . "</td>");
                            echo ("<td>" . $producto->__get("precio") . "</td>");
                            echo ("<td>" . $producto->__get("categoria") . "</td>");
                            $imagenBase64 = base64_encode($producto->__get("imagen"));
                            echo "<td><img src='data:image/jpeg;base64,$imagenBase64' width=100 height=100 ></td>";
                            echo ("</tr>");
                        }
                        ?>
                    </table>
                    <input type='submit' class="btn btn-danger" name='Borrar' value='Borrar'>
                </form>

            </div>
        </div>
    </div>
    <button onclick="window.location.href='../php/tienda.php';" type="button" class="btn btn-primary">Volver al inicio</button>
</body>

</html>