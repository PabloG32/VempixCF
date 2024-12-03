<link rel="stylesheet" href="../css/toast.css">
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
        $categoria = $_POST['categoria'];;
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);

        $producto = new Producto();

        $producto->__set("nombre", $nombre);
        $producto->__set("descripcion", $descripcion);
        $producto->__set("precio", $precio);
        $producto->__set("categoria", $categoria);
        $producto->__set("imagen", $imagen);

        $daoProd->insertar($producto);
?>
        <div id="toast">Producto añadido correctamente</div>

        <script>
            function showToast() {
                var toast = document.getElementById("toast");
                toast.className = "show";
                setTimeout(function() {
                    toast.className = toast.className.replace("show", "");
                    window.location.href = '../php/tienda.php';
                }, 2000);
            }
            showToast();
        </script>
    <?php

        break;
    case "crearC": //La operación de crear una nueva categoria
        $nombre = $_POST['nombre'];

        $categoria = new Categoria();

        $categoria->__set("nombre", $nombre);

        $daoCat->insertar($categoria);
    ?>
        <div id="toast">Categoria añadida correctamente</div>

        <script>
            function showToast() {
                var toast = document.getElementById("toast");
                toast.className = "show";
                setTimeout(function() {
                    toast.className = toast.className.replace("show", "");
                    window.location.href = '../php/tienda.php';
                }, 2000);
            }
            showToast();
        </script>
<?php

        break;
    case "listadocategorias": //Listar las categorias
        $daoCat->listar();
        $categorias = $daoCat->categorias;
        include_once 'listadocategorias.php';

        break;
}
