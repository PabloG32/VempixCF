<?php

require_once 'Categoria.php';
require_once 'libreriaPDO.php';

class DaoCategoria extends DB
{
    public $categorias = array();

    //Lista el contenido de la tabla
    public function listar()
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

    //Metodo para insertar una categoria
    public function insertar($categoria)
    {

        $consulta = "insert into categorias values(NULL, :nombre)";

        $param = array();

        $param[":nombre"] = $categoria->__get("nombre");

        $this->ConsultaSimple($consulta, $param);
    }

    //Metodo que borra una categoria y sus productos
    public function Borrar($id)
    {
        $consultaP = "delete from productos where categoria=:id";
        $consultaC = "delete from categorias where id=:id";

        $param = array(":id" => $id);

        $this->ConsultaSimple($consultaP, $param);
        $this->ConsultaSimple($consultaC, $param);
    }

    //Metodo para comprobar si existe esa categoria
    public function existeCategoria($nombre)
    {
        $consulta = "SELECT COUNT(*) FROM categorias WHERE nombre = :nombre";
        $param = [':nombre' => $nombre];

        $fila = $this->ConsultaDatos($consulta, $param);
        $count = $fila[0]['COUNT(*)'];

        return $count > 0;
    }
}
