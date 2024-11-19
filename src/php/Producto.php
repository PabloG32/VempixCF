<?php

class Producto
{
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoria;
    private $imagen;


    public function __get($nombre)
    {
        return $this->$nombre;
    }
    public function __set($nombre, $valor)
    {
        $this->$nombre = $valor;
    }
}
