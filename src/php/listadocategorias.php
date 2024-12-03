<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/Logo.jpeg" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Listado de categorias</title>
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
    require_once 'DaoCategoria.php';
    $base = "vempixcf";
    $daoCat = new DaoCategoria($base);

    if (isset($_POST['Borrar']) && isset($_POST['Selec']))  //Si hemos seleccionado alguna categoria y pulsado borrar
    {
        $selec = $_POST['Selec']; //Recogemos los ids del los checkboxes seleccionados

        foreach ($selec as $clave => $valor) {
            $daoCat->Borrar($clave);
        }
        header("Location: controller.php?operacion=listadocategorias");
        exit();
    }
    ?>
    <div class="d-flex justify-content-center align-items-center">
        <h1 class="display-5">Listado de categorias</h1>
    </div>
    <div class="container mt-4">
        <form action="" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
            <table class="table">
                <tr>
                    <th class='table-dark'>Seleccionar</th>
                    <th class='table-dark'>Nombre</th>
                </tr>
                <?php

                foreach ($categorias as $categoria) {
                    echo ("<tr class='table-primary'>");
                    echo ("<td class='table-primary'><input type='checkbox'  name='Selec[" . $categoria->__get("id") . "]'></td>");
                    echo ("<td class='table-primary'>" . $categoria->__get("nombre") . "</td>");
                    echo ("</tr>");
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