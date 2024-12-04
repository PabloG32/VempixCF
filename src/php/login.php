<link rel="stylesheet" href="../css/toastError.css">
<?php
session_start();
require_once('libreriaPDO.php');

if (isset($_POST['inicio'])) {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    // Validar campos vacíos
    if (empty($email) || empty($password)) {
        die("Debe llenar todos los campos.");
    }

    try {
        $db = new DB('vempixcf');

        //Buscamos el usuario con dicho email
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $usuario = $db->ConsultaDatos($sql);

        if ($usuario && $password == $usuario[0]['password']) {
            // Almacenar la información del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario[0]['id'];
            $_SESSION['nombre'] = $usuario[0]['nombre'];
            $_SESSION['email'] = $usuario[0]['email'];
            $_SESSION['direccion'] = $usuario[0]['direccion'];
            $_SESSION['rol'] = $usuario[0]['rol'];

            echo "<script>window.location.href='../php/tienda.php';</script>";
            exit();
        } else {
            // echo "Credenciales incorrectas. Inténtelo nuevamente.";
            // exit();
?>
            <div id="toastError">Credenciales incorrectas</div>
            <script>
                function showToast() {
                    var toast = document.getElementById("toastError");
                    toast.className = "show";
                    setTimeout(function() {
                        toast.className = toast.className.replace("show", "");
                        window.location.href = '../index.html';
                    }, 3000);
                }
                showToast();
            </script>
<?php
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
