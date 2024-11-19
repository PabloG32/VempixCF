<?php

require_once 'Producto.php';
require_once 'libreriaPDO.php';

class DaoProducto extends DB
{
    public $productos = array();

    public function listar() //Lista el contenido de la tabla
    {
        $consulta = "select * from productos ";

        $param = array();

        $this->productos = array();

        $this->ConsultaDatos($consulta);

        foreach ($this->filas as $fila) {
            $prod = new Producto();

            $prod->__set("id", $fila['id']);
            $prod->__set("nombre", $fila['nombre']);
            $prod->__set("descripcion", $fila['descripcion']);
            $prod->__set("precio", $fila['precio']);
            $prod->__set("categoria", $fila['categoria']);
            $prod->__set("imagen", $fila['imagen']);

            $this->productos[] = $prod;   //Insertamos el objeto con los valores de esa fila en el array de objetos

        }
    }

    public function insertar($producto) //Recibe como parámetro un objeto con los datos del producto
    {

        $consulta = "insert into productos values(NULL, :nombre, :descripcion, :precio, :categoria, :imagen)";

        $param = array();

        $param[":nombre"] = $producto->__get("nombre");
        $param[":descripcion"] = $producto->__get("descripcion");
        $param[":precio"] = $producto->__get("precio");
        $param[":categoria"] = $producto->__get("categoria");
        $param[":imagen"] = $producto->__get("imagen");

        $this->ConsultaSimple($consulta, $param);
    }

    public function Borrar($id) //Metodo que borra un producto
    {
        $consulta = "delete from productos where id=:id";

        $param = array(":id" => $id);

        $this->ConsultaSimple($consulta, $param);
    }
}
