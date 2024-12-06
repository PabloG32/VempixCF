<?php
session_start();
require_once('DaoCarrito.php');
require_once('DaoProducto.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit();
}
$base = "vempixcf";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/Logo.jpeg" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Carrito</title>
    <link rel="stylesheet" href="../css/carrito.css">
    <link rel="stylesheet" href="../css/toastBien.css">
</head>

<body>
    <?php
    //Vemos las diferentes acciones
    $accion = isset($_GET['accion']) ? $_GET['accion'] : 'ver';

    switch ($accion) {
        case 'agregar':
            agregarProductoAlCarrito();
            break;
        case 'ver':
            verCarrito();
            break;
        case 'eliminar':
            eliminarProductoDelCarrito();
            break;
        default:
            verCarrito();
            break;
    }

    function agregarProductoAlCarrito()
    {
        global $base;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $producto_id = $_POST['id'];
            $cantidad = $_POST['cantidad'];
            $usuario_id = $_SESSION['usuario_id'];

            if ($cantidad < 1) {
                die("La cantidad debe ser al menos 1.");
            }

            try {
                $DaoCarrito = new DaoCarrito($base);
                $DaoCarrito->agregarProducto($usuario_id, $producto_id, $cantidad);
    ?>
                <div class='alert alert-success mt-5' role='alert'>Producto añadido al carrito correctamente.</div>
                <script>
                    setTimeout(function() {
                        window.location.href = './tienda.php';
                    }, 2000);
                </script>
    <?php
            } catch (Exception $e) {
                echo "Error al añadir el producto al carrito: " . $e->getMessage();
            }
        } else {
            echo "Método de solicitud no válido.";
        }
    }

    function verCarrito()
    {
        global $base;
        $usuario_id = $_SESSION['usuario_id'];

        try {
            $DaoCarrito = new DaoCarrito($base);
            $productos = $DaoCarrito->obtenerProductosEnCarrito($usuario_id);
            $total = 0;
            echo "<h1>Carrito de Compras</h1>";
            if (count($productos) > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table'>";
                echo "<thead>";
                echo "<tr class='table-dark'><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th><th>Accion</th></tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($productos as $producto) {
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                    $total += $subtotal;
                    echo "<tr class='table-dark'>";
                    echo "<td class='table-dark'>" . $producto['nombre'] . "</td>";
                    echo "<td class='table-dark'>" . $producto['cantidad'] . "</td>";
                    echo "<td class='table-dark'>" . $producto['precio'] . "€</td>";
                    echo "<td class='table-dark'>" . $subtotal . "€</td>";
                    echo "<td class='table-dark'><a class='btn btn-danger btn-sm' href='accionesCarrito.php?accion=eliminar&producto_id=" . $producto['id'] . "'>Eliminar</a></td>";
                    echo "</tr class='table-dark'>";
                }
                echo "
                    <td colspan='3' class='table-dark'></td>
                    <td class='table-dark'>
                        <p class='h3' id='total'>" . $total . "€</p>
                    </td>
                    <td class='table-dark'><a href='./pagar.php' class='btn btn-primary'>Pagar</a></td>
                    ";
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<h3 class='c_vacio'>El carrito está vacío.</h3>";
            }
            echo "<a class='link-light text-decoration-none' href='tienda.php'>Volver a la tienda</a>";
        } catch (Exception $e) {
            echo "Error al obtener el carrito: " . $e->getMessage();
        }
    }

    function eliminarProductoDelCarrito()
    {
        global $base;
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $producto_id = $_GET['producto_id'];
            $usuario_id = $_SESSION['usuario_id'];

            try {
                $DaoCarrito = new DaoCarrito($base);
                $DaoCarrito->eliminarProducto($usuario_id, $producto_id);
                echo "<script>window.location.href='./accionesCarrito.php?accion=ver';</script>";
                exit();
            } catch (Exception $e) {
                echo "Error al eliminar el producto del carrito: " . $e->getMessage();
            }
        } else {
            echo "Método de solicitud no válido.";
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</body>

</html>