<link rel="stylesheet" href="../css/toastBien.css">
<link rel="stylesheet" href="../css/toastError.css">
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

    // Comprobar si el usuario ya existe en la base de datos
    if ($daoUsu->existeUsuario($email)) {
?>
        <div id="toastError">El usuario ya existe</div>
        <script>
            function showToast() {
                var toast = document.getElementById("toastError");
                toast.className = "show";
                setTimeout(function() {
                    toast.className = toast.className.replace("show", "");
                    window.location.href = '../index.html';
                }, 2000);
            }
            showToast();
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
        <div id="toastBien">Usuario creado correctamente</div>
        <script>
            function showToast() {
                var toast = document.getElementById("toastBien");
                toast.className = "show";
                setTimeout(function() {
                    toast.className = toast.className.replace("show", "");
                    window.location.href = '../index.html';
                }, 2000);
            }
            showToast();
        </script>
<?php
    }
}
