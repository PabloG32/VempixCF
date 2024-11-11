<?php

// Incluir el archivo de la librería DB
include 'libreriaPDO.php';

// Crear un objeto de la clase DB y pasarle el nombre de la base de datos
$db = new DB('vempixcf');

// Definir la consulta SQL para obtener los datos de productos
$sql = "SELECT id, nombre, precio, descripcion, categoria, imagen FROM productos";

try {
    // Ejecutar la consulta y obtener los resultados
    $resultados = $db->ConsultaDatos($sql);
} catch (Exception $e) {
    // Si ocurre un error, devolver un mensaje de error y salir
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

// Crear un arreglo para almacenar los productos
$productos = [];

// Recorrer los resultados y convertir las imágenes a base64
foreach ($resultados as $row) {
    if ($row['imagen']) {
        $row['imagen'] = base64_encode($row['imagen']);
    }
    $productos[] = $row;
}

// Crear el JSON final con el array "productos"
$jsonData = json_encode(["productos" => $productos], JSON_PRETTY_PRINT);

// Guardar el JSON en un archivo
$file = '../js/productos.json';
if (file_put_contents($file, $jsonData)) {
    echo "El archivo JSON se ha creado exitosamente: $file";
} else {
    echo "Error al crear el archivo JSON.";
}
