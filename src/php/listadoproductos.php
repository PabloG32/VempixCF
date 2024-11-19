<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Listado de productos</title>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center">
        <h1 class="display-5">Listado de productos</h1>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
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
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-danger">Borrar</button>
    <button onclick="window.location.href='../html/index.html';" type="button" class="btn btn-primary">Volver al inicio</button>
</body>

</html>