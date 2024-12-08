<?php
session_start();
require_once('libreriaPDO.php');
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
<link rel='stylesheet' href='../css/login.css'>";

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
?>
            <div class="alert alert-danger mt-5" role='alert'>Credenciales incorrectas.</div>
            <script>
                setTimeout(function() {
                    window.location.href = '../index.html';
                }, 2000);
            </script>
<?php
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
