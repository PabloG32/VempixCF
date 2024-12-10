<?php
require_once './libreriaPDO.php';
require_once './usuario.php';

class DaoUsuarios extends DB
{
    public $usuarios = array();

    public function __construct($base)
    {
        $this->dbname = $base;
    }

    //Insertar usuario
    public function insertar($usu)
    {
        $consulta = "INSERT INTO usuarios (nombre, email, password, direccion, rol) VALUES (:nombre, :email, :password, :direccion, :rol)";

        $param = array();

        $param[":nombre"] = $usu->__get("nombre");
        $param[":email"] = $usu->__get("email");
        $param[":password"] = $usu->__get("password");
        $param[":direccion"] = $usu->__get("direccion");
        $param[":rol"] = $usu->__get("rol");

        $this->ConsultaSimple($consulta, $param);
    }

    //Metodo para comprobar si existe ese usuario
    public function existeUsuario($email)
    {
        $consulta = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $param = [':email' => $email];

        $fila = $this->ConsultaDatos($consulta, $param);
        $count = $fila[0]['COUNT(*)'];

        return $count > 0;
    }
}
