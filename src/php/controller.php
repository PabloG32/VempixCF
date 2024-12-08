<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<?php

require_once 'Producto.php';
require_once 'Categoria.php';
require_once 'Noticia.php';
require_once 'DaoProducto.php';
require_once 'DaoCategoria.php';
require_once 'DaoNoticia.php';

$base = "vempixcf";

$operacion = $_GET['operacion'];

$daoProd = new DaoProducto($base);
$daoCat = new DaoCategoria($base);
$daoNot = new DaoNoticia($base);

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
            <div class="alert alert-danger mt-5" role='alert'>El producto con ese nombre ya existe.</div>
            <script>
                setTimeout(function() {
                    window.location.href = '../php/newProducto.php';
                }, 2000);
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
            <div class="alert alert-success mt-5" role='alert'>Producto añadido correctamente.</div>
            <script>
                setTimeout(function() {
                    window.location.href = './tienda.php';
                }, 2000);
            </script>
        <?php
        }
        break;
    case "crearC": //La operación de crear una nueva categoría
        $nombre = $_POST['nombre'];

        // Comprobar si la categoría ya existe en la base de datos
        if ($daoCat->existeCategoria($nombre)) {
        ?>
            <div class="alert alert-danger mt-5" role='alert'>La categoría con ese nombre ya existe.</div>
            <script>
                setTimeout(function() {
                    window.location.href = '../php/newCategoria.php';
                }, 2000);
            </script>
        <?php
        } else {
            $categoria = new Categoria();
            $categoria->__set("nombre", $nombre);

            $daoCat->insertar($categoria);
        ?>
            <div class="alert alert-success mt-5" role='alert'>Categoría añadida correctamente.</div>
            <script>
                setTimeout(function() {
                    window.location.href = './tienda.php';
                }, 2000);
            </script>
        <?php
        }
        break;
    case "listadocategorias": //Listar las categorias
        $daoCat->listar();
        $categorias = $daoCat->categorias;
        include_once 'listadocategorias.php';

        break;

    case "crearN": //La operación de crear una noticia
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $fecha = $_POST['fecha'];
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);

        // Comprobar si el producto ya existe en la base de datos
        if ($daoNot->existeNoticia($titulo)) {
        ?>
            <div class="alert alert-danger mt-5" role='alert'>La noticia ya existe.</div>
            <script>
                setTimeout(function() {
                    window.location.href = './tienda.php';
                }, 2000);
            </script>
        <?php
        } else {
            $noticia = new Noticia();

            $noticia->__set("titulo", $titulo);
            $noticia->__set("contenido", $contenido);
            $noticia->__set("fecha", $fecha);
            $noticia->__set("imagen", $imagen);

            $daoNot->insertar($noticia);
        ?>
            <div class="alert alert-success mt-5" role='alert'>Noticia añadida correctamente.</div>
            <script>
                setTimeout(function() {
                    window.location.href = './tienda.php';
                }, 2000);
            </script>

<?php
        }
        break;
    case "listadonoticias":
        $daoNot->listar();
        $noticias = $daoNot->noticias;
        include_once 'listadonoticias.php';

        break;
}
