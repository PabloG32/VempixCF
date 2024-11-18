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

    $usuario = new Usuario();

    $usuario->__set("nombre", $nombre);
    $usuario->__set("email", $email);
    $usuario->__set("password", $password);
    $usuario->__set("direccion", $direccion);
    $usuario->__set("rol", $rol);

    $daoUsu->insertar($usuario);

    // Redirigir a la página de inicio después de crear el usuario
    echo "
        <script>
            alert('Usuario creado correctamente');
            window.location.href = '/vempixcf2/VempixCF/src/html/index.html';
        </script>";
    exit;
}
