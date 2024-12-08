<?php

require_once 'Noticia.php';
require_once 'libreriaPDO.php';

class DaoNoticia extends DB
{
    public $noticias = array();

    public function listar()
    {
        $consulta = "select * from noticias";

        $param = array();

        $this->noticias = array();

        $this->ConsultaDatos($consulta);

        foreach ($this->filas as $fila) {
            $noti = new Noticia();

            $noti->__set("id", $fila['id']);
            $noti->__set("titulo", $fila['titulo']);
            $noti->__set("contenido", $fila['contenido']);
            $noti->__set("fecha", $fila['fecha']);
            $noti->__set("imagen", $fila['imagen']);

            $this->noticias[] = $noti;
        }
    }

    public function insertar($noticia)
    {

        $consulta = "insert into noticias values(NULL, :titulo, :contenido, :fecha, :imagen)";

        $param = array();

        $param[":titulo"] = $noticia->__get("titulo");
        $param[":contenido"] = $noticia->__get("contenido");
        $param[":fecha"] = $noticia->__get("fecha");
        $param[":imagen"] = $noticia->__get("imagen");

        $this->ConsultaSimple($consulta, $param);
    }

    public function Borrar($id)
    {
        $consulta = "delete from noticias where id=:id";

        $param = array(":id" => $id);

        $this->ConsultaSimple($consulta, $param);
    }

    public function existeNoticia($titulo)
    {
        $consulta = "SELECT COUNT(*) FROM noticias WHERE titulo = :titulo";
        $param = [':titulo' => $titulo];

        $fila = $this->ConsultaDatos($consulta, $param);
        $count = $fila[0]['COUNT(*)'];

        return $count > 0;
    }
}
