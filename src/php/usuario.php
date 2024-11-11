<?php

class Usuario
{
    private $Usuario;
    private $id;
    private $nombre;
    private $email;
    private $password;
    private $direccion;
    private $rol;

    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
