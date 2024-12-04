<link rel="stylesheet" href="../css/toastBien.css">
<link rel="stylesheet" href="../css/toastError.css">
<?php

require_once 'Producto.php';
require_once 'Categoria.php';
require_once 'DaoProducto.php';
require_once 'DaoCategoria.php';

$base = "vempixcf";

$operacion = $_GET['operacion'];

$daoProd = new DaoProducto($base);
$daoCat = new DaoCategoria($base);

switch ($operacion) {
    case "listadoproductos": //Listar los productos
        $daoProd->listar();
        $productos = $daoProd->productos;
        include_once 'listadoproductos.php';

        break;
    case "crear": //La operación de crear un nuevo producto
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);

        // Comprobar si el producto ya existe en la base de datos
        if ($daoProd->existeProducto($nombre)) {
?>
            <div id="toastError">El producto con ese nombre ya existe</div>
            <script>
                function showToast() {
                    var toast = document.getElementById("toastError");
                    toast.className = "show";
                    setTimeout(function() {
                        toast.className = toast.className.replace("show", "");
                        window.location.href = '../php/newProducto.php';
                    }, 2000);
                }
                showToast();
            </script>
        <?php
        } else {
            $producto = new Producto();

            $producto->__set("nombre", $nombre);
            $producto->__set("descripcion", $descripcion);
            $producto->__set("precio", $precio);
            $producto->__set("categoria", $categoria);
            $producto->__set("imagen", $imagen);

            $daoProd->insertar($producto);
        ?>
            <div id="toastBien">Producto añadido correctamente</div>

            <script>
                function showToast() {
                    var toast = document.getElementById("toastBien");
                    toast.className = "show";
                    setTimeout(function() {
                        toast.className = toast.className.replace("show", "");
                        window.location.href = '../php/tienda.php';
                    }, 2000);
                }
                showToast();
            </script>
        <?php
        }
        break;
    case "crearC": //La operación de crear una nueva categoría
        $nombre = $_POST['nombre'];

        // Comprobar si la categoría ya existe en la base de datos
        if ($daoCat->existeCategoria($nombre)) {
        ?>
            <div id="toastError">La categoría con ese nombre ya existe</div>

            <script>
                function showToast() {
                    var toast = document.getElementById("toastError");
                    toast.className = "show";
                    setTimeout(function() {
                        toast.className = toast.className.replace("show", "");
                        window.location.href = '../php/newCategoria.php';
                    }, 2000);
                }
                showToast();
            </script>
        <?php
        } else {
            $categoria = new Categoria();
            $categoria->__set("nombre", $nombre);

            $daoCat->insertar($categoria);
        ?>
            <div id="toastBien">Categoría añadida correctamente</div>

            <script>
                function showToast() {
                    var toast = document.getElementById("toastBien");
                    toast.className = "show";
                    setTimeout(function() {
                        toast.className = toast.className.replace("show", "");
                        window.location.href = '../php/tienda.php';
                    }, 2000);
                }
                showToast();
            </script>
<?php
        }
        break;
    case "listadocategorias": //Listar las categorias
        $daoCat->listar();
        $categorias = $daoCat->categorias;
        include_once 'listadocategorias.php';

        break;
}
