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

    // public function insertar($carrito)
    // {
    //     $consulta = "insert into carrito values(NULL,:idUsuario,:idProducto,:cantidad)";

    //     $param = array();
    //     $param[":idUsuario"] = $carrito->__get("idUsuario");
    //     $param[":idProducto"] = $carrito->__get("idProducto");
    //     $param[":cantidad"] = $carrito->__get("cantidad");

    //     $this->ConsultaSimple($consulta, $param);
    // }

    // Método para agregar un producto al carrito del usuario con una cantidad específica
    public function agregarProducto($usuario_id, $producto_id, $cantidad)
    {
        // Si el producto ya existe en el carrito, incrementa la cantidad
        $sql = "INSERT INTO carrito (idUsuario, idProducto, cantidad) 
                VALUES (:usuario_id, :producto_id, :cantidad)
                ON DUPLICATE KEY UPDATE cantidad = cantidad + :cantidad";
        $params = [
            ':usuario_id' => $usuario_id,
            ':producto_id' => $producto_id,
            ':cantidad' => $cantidad
        ];
        try {
            $this->consultaSimple($sql, $params);
        } catch (PDOException $e) {
            throw new Exception("Error al agregar el producto al carrito: " . $e->getMessage());
        }
    }

    // Método para obtener los productos que están en el carrito del usuario
    public function obtenerProductosEnCarrito($usuario_id)
    {
        $sql = "SELECT p.id, p.nombre, p.precio, c.cantidad 
                FROM productos p 
                JOIN carrito c ON p.id = c.idProducto
                WHERE c.idUsuario = :usuario_id";
        $params = [':usuario_id' => $usuario_id];
        try {
            return $this->consultaDatos($sql, $params);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener los productos del carrito: " . $e->getMessage());
        }
    }

    // Método para eliminar un producto del carrito del usuario
    public function eliminarProducto($usuario_id, $producto_id)
    {
        $sql = "DELETE FROM carrito WHERE idUsuario = :usuario_id AND idProducto = :producto_id";
        $params = [
            ':usuario_id' => $usuario_id,
            ':producto_id' => $producto_id
        ];
        try {
            $this->consultaSimple($sql, $params);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar el producto del carrito: " . $e->getMessage());
        }
    }

    // Método para vaciar completamente el carrito del usuario
    public function vaciarCarrito($usuario_id)
    {
        $sql = "DELETE FROM carrito WHERE idUsuario = :usuario_id";
        $params = [':usuario_id' => $usuario_id];
        try {
            $this->consultaSimple($sql, $params);
        } catch (PDOException $e) {
            throw new Exception("Error al vaciar el carrito: " . $e->getMessage());
        }
    }
}
