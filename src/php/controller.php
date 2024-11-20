<style>
    body {
        background-image: url(../img/fondo.jpg);
        /* background: linear-gradient(130deg, green, blue); */
    }

    /* Estilo para el toast */
    #toast {
        visibility: hidden;
        min-width: 250px;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        /* Centrar el toast en la pantalla */
        font-size: 17px;
    }

    /* Mostrar el toast cuando se active */
    #toast.show {
        visibility: visible;
        animation: fadeInOut 2s;
        /* Animación de 2 segundos */
    }
</style>
<?php

require_once 'Producto.php';
require_once 'DaoProducto.php';

$base = "vempixcf";

$operacion = $_GET['operacion'];

$daoProd = new DaoProducto($base);

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
                    window.location.href = '../html/index.html';
                }, 2000);
            }
            showToast();
        </script>
<?php

        break;
}
