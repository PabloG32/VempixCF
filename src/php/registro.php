<link rel="stylesheet" href="../css/toast.css">
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

?>
    <div id="toast">Usuario creado correctamente</div>

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
}
