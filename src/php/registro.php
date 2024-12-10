<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="../css/login.css">
<?php

require_once './DaoUsuarios.php';

$base = "vempixcf";

$daoUsu = new DaoUsuarios($base);

if (isset($_POST['alta'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $direccion = $_POST['direccion'];
    $rol = 1;

    if (empty($email) || empty($nombre) || empty($password) || empty($direccion)) {
?>
        <div class="alert alert-danger mt-5" role='alert'>Ningun campo puede estar vacío.</div>
        <script>
            setTimeout(function() {
                window.location.href = '../index.html';
            }, 2000);
        </script>
    <?php
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    ?>
        <div class="alert alert-danger mt-5" role='alert'>El correo electrónico ingresado no es válido.</div>
        <script>
            setTimeout(function() {
                window.location.href = '../index.html';
            }, 2000);
        </script>
        <?php
    } else {
        if ($daoUsu->existeUsuario($email)) {
        ?>
            <div class="alert alert-danger mt-5" role='alert'>El usuario ya existe.</div>
            <script>
                setTimeout(function() {
                    window.location.href = '../index.html';
                }, 2000);
            </script>
        <?php
        } else {
            $usuario = new Usuario();
            $usuario->__set("nombre", $nombre);
            $usuario->__set("email", $email);
            $usuario->__set("password", $password);
            $usuario->__set("direccion", $direccion);
            $usuario->__set("rol", $rol);

            $daoUsu->insertar($usuario);
        ?>
            <div class="alert alert-success mt-5" role='alert'>Usuario creado correctamente.</div>
            <script>
                setTimeout(function() {
                    window.location.href = '../index.html';
                }, 2000);
            </script>
<?php
        }
    }
}
