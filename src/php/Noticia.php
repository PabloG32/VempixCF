<?php

class Noticia
{
    private $id;
    private $titulo;
    private $contenido;
    private $fecha;
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
