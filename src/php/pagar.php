<?php
session_start();
require_once('DaoCarrito.php');
require_once('DaoProducto.php');
require_once 'libreriaPDO.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit();
}
$base = "vempixcf";
$usuario_id = $_SESSION['usuario_id'];
$DaoCarrito = new DaoCarrito($base);
$productos = $DaoCarrito->obtenerProductosEnCarrito($usuario_id);
$total = 0;
$db = new DB($base);
$country = "";

if (isset($_POST['country'])) {
    $country = $_POST['country'];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/Logo.png" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/checkout.css">
    <title>VempixCF</title>
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST['pagar'])) {

            $DaoCarrito->vaciarCarrito($usuario_id);

            echo "<div class='alert alert-success' role='alert'>Pago ejecutado con éxito.</div>";
            echo "
            <script>
                setTimeout(function() {
                    window.location.href = './tienda.php';
                }, 2000);
            </script>
            ";
        }
        ?>
        <main>
            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <form name="fP" method="post" action="">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span>Tu carrito</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <?php
                            if ($productos > 0) {
                                foreach ($productos as $producto) {
                                    $subtotal = $producto['precio'] * $producto['cantidad'];
                                    $total += $subtotal;
                                    echo "<li class='list-group-item'>";
                                    echo "<div>";
                                    echo "<h6 class='my-0'>" . $producto['nombre'] . "</h6>";
                                    echo "<small class='text-body-secondary'>" . $producto['descripcion'] . "</small>";
                                    echo "</div>";
                                    echo "<span class='text-body-secondary'>" . $producto['precio'] . "€</span>";
                                    echo "</li";
                                    echo "<hr>";
                                }
                            } else {
                                echo "<li class='list-group-item'>Your cart is empty</li>";
                            }
                            ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong><?php echo $total; ?>€</strong>
                            </li>
                        </ul>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Codigo descuento">
                            <button type="submit" class="btn btn-secondary">Añadir</button>
                        </div>

                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Dirección de facturación</h4>

                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="firstName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="firstName" value="<?= $_SESSION['nombre']; ?>">
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" class="form-control" id="email" value="<?= $_SESSION['email']; ?>">
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="address" value="<?= $_SESSION['direccion']; ?>">
                        </div>

                        <div class="col-md-5">
                            <label for="country" class="form-label">Pais</label>
                            <select class="form-select" name="country" id="country">
                                <option value="">Choose...</option>
                                <?php
                                $consulta = "select * from paises";
                                $db->ConsultaDatos($consulta);
                                foreach ($db->filas as $fila) {
                                    echo "<option value=$fila[Codigo] ";
                                    if ($country == $fila['Codigo']) {
                                        echo " selected ";
                                    }
                                    echo "> $fila[Pais]</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="zip" class="form-label">Zip</label>
                            <input type="number" class="form-control" id="zip">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="same-address">
                        <label class="form-check-label" for="same-address">La dirección de envío es la misma que mi dirección de facturación</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="save-info">
                        <label class="form-check-label" for="save-info">Guarde esta información para la próxima vez</label>
                    </div>

                    <hr class="my-4">

                    <h4 class="mb-3">Pago</h4>

                    <div class="my-3">
                        <div class="form-check">
                            <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked>
                            <label class="form-check-label" for="credit">Tarjeta de crédito</label>
                        </div>
                        <div class="form-check">
                            <input id="debit" name="paymentMethod" type="radio" class="form-check-input">
                            <label class="form-check-label" for="debit">Tarjeta de débito</label>
                        </div>
                        <div class="form-check">
                            <input id="paypal" name="paymentMethod" type="radio" class="form-check-input">
                            <label class="form-check-label" for="paypal">PayPal</label>
                        </div>
                    </div>

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label for="cc-name" class="form-label">Nombre en la tarjeta</label>
                            <input type="text" class="form-control" id="cc-name" placeholder="">
                        </div>

                        <div class="col-md-6">
                            <label for="cc-number" class="form-label">Número de tarjeta de crédito</label>
                            <input type="text" class="form-control" id="cc-number">
                        </div>

                        <div class="col-md-3">
                            <label for="cc-expiration" class="form-label">Vencimiento</label>
                            <input type="text" class="form-control" id="cc-expiration" placeholder="">
                        </div>

                        <div class="col-md-3">
                            <label for="cc-cvv" class="form-label">CVV</label>
                            <input type="number" class="form-control" id="cc-cvv" maxlength="3">
                        </div>
                    </div>

                    <hr class="my-4">
                    <input class="w-100 btn btn-primary btn-lg" type="submit" name="pagar" value="Pagar">
                    </form>
                    <br>
                    <button class=" mt-2 w-100 btn btn-primary btn-lg" onclick="window.location.href='../php/accionesCarrito.php?accion=ver';">Volver</button>
                </div>
            </div>
        </main>
    </div>
</body>

</html>