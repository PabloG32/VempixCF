<?php

class Carrito
{
    private $id;
    private $idUsuario;
    private $idProducto;
    private $cantidad;

    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
