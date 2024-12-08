<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/Logo.jpeg" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>VempixCF</title>
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
    require_once 'DaoNoticia.php';
    $base = "vempixcf";
    $daoNot = new DaoNoticia($base);

    if (isset($_POST['Borrar']) && isset($_POST['Selec'])) {
        $selec = $_POST['Selec'];

        foreach ($selec as $clave => $valor) {
            $daoNot->Borrar($clave);
        }
        echo "<script>window.location.href='./controller.php?operacion=listadonoticias';</script>";
        exit();
    }
    ?>
    <div class="d-flex justify-content-center align-items-center">
        <h1 class="display-5">Listado de noticias</h1>
    </div>
    <div class="container mt-4">
        <form method="post" action='' enctype='multipart/form-data'>
            <table class="table">
                <tr>
                    <th class="table-dark">Seleccionar</th>
                    <th class="table-dark">Titulo</th>
                    <th class="table-dark">Contenido</th>
                    <th class="table-dark">Fecha</th>
                    <th class="table-dark">Imagen</th>
                </tr>
                <?php

                foreach ($noticias as $noticia) {
                    echo ("<tr class='table-primary'>");
                    echo ("<td class='table-primary'><input type='checkbox'  name='Selec[" . $noticia->__get("id") . "]'></td>");
                    echo ("<td class='table-primary'>" . $noticia->__get("titulo") . "</td>");
                    echo ("<td class='table-primary'>" . $noticia->__get("contenido") . "</td>");
                    echo ("<td class='table-primary'>" . $noticia->__get("fecha") . "</td>");
                    $imagenBase64 = base64_encode($noticia->__get("imagen"));
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