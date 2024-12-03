<?php

require_once 'Categoria.php';
require_once 'libreriaPDO.php';

class DaoCategoria extends DB
{
    public $categorias = array();

    public function listar() //Lista el contenido de la tabla
    {
        $consulta = "select * from categorias ";

        $param = array();

        $this->categorias = array();

        $this->ConsultaDatos($consulta);

        foreach ($this->filas as $fila) {
            $cat = new Categoria();

            $cat->__set("id", $fila['id']);
            $cat->__set("nombre", $fila['nombre']);

            $this->categorias[] = $cat;
        }
    }

    public function insertar($categoria) //Metodo para insertar una categoria
    {

        $consulta = "insert into categorias values(NULL, :nombre)";

        $param = array();

        $param[":nombre"] = $categoria->__get("nombre");

        $this->ConsultaSimple($consulta, $param);
    }

    public function Borrar($id) //Metodo que borra una categoria y sus productos
    {
        $consultaP = "delete from productos where categoria=:id";
        $consultaC = "delete from categorias where id=:id";

        $param = array(":id" => $id);

        $this->ConsultaSimple($consultaP, $param);
        $this->ConsultaSimple($consultaC, $param);
    }
}
