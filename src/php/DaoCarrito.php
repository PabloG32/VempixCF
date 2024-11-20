<?php

require_once 'libreriaPDO.php';
require_once 'carrito.php';

class DaoCarrito extends DB
{
    public $carritos = array();

    public function __construct($base)
    {
        $this->dbname = $base;
    }

    public function insertar($carrito)
    {
        $consulta = "insert into carrito values(NULL,:idUsuario,:idProducto,:cantidad)";

        $param = array();
        $param[":idUsuario"] = $carrito->__get("idUsuario");
        $param[":idProducto"] = $carrito->__get("idProducto");
        $param[":cantidad"] = $carrito->__get("cantidad");

        $this->ConsultaSimple($consulta, $param);
    }
}
