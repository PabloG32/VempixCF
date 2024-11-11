<?php
include 'libreriaPDO.php';

$db = new DB('vempixcf');

// Las consultas SQL para obtener los datos de productos y categorías
$sqlProd = "SELECT id, nombre, precio, descripcion, categoria, imagen FROM productos";
$sqlCat = "SELECT id, nombre FROM categorias";

try {
    $resultadosProd = $db->ConsultaDatos($sqlProd);
    $resultadosCat = $db->ConsultaDatos($sqlCat);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

// Crear arrays para almacenar los productos y las categorías con productos asignados
$productos = [];
$categorias = [];
$productosPorCategoria = []; // Array para agrupar productos por categoría

// Recorrer los resultados de productos, convertir las imágenes a base64, y agrupar productos por categoría
foreach ($resultadosProd as $row) {
    if ($row['imagen']) {
        $row['imagen'] = base64_encode($row['imagen']);
    }
    $productos[] = $row;

    // Agrupar productos por categoría
    $catId = $row['categoria'];
    if (!isset($productosPorCategoria[$catId])) {
        $productosPorCategoria[$catId] = [];
    }
    $productosPorCategoria[$catId][] = $row['nombre'];
}

// Recorrer los resultados de categorías y añadir los nombres de los productos asignados
foreach ($resultadosCat as $row) {
    $catId = $row['id'];
    $row['productos'] = $productosPorCategoria[$catId] ?? []; // Añadir nombres de productos
    $categorias[] = $row;
}

// Crear el JSON final con los arrays
$jsonData = json_encode([
    "productos" => $productos,
    "categorias" => $categorias
], JSON_PRETTY_PRINT);

// Guardar el JSON en un archivo
$file = '../js/productos.json';
if (file_put_contents($file, $jsonData)) {
    echo "El archivo JSON se ha creado exitosamente: $file";
} else {
    echo "Error al crear el archivo JSON.";
}
