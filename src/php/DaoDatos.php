<?php
include 'libreriaPDO.php';

$db = new DB('vempixcf');

$sqlProd = "SELECT id, nombre, precio, descripcion, categoria, imagen FROM productos";
$sqlCat = "SELECT id, nombre FROM categorias";
$sqlNot = "SELECT id, titulo, contenido, fecha, imagen FROM noticias";

try {
    $resultadosProd = $db->ConsultaDatos($sqlProd);
    $resultadosCat = $db->ConsultaDatos($sqlCat);
    $resultadosNot = $db->ConsultaDatos($sqlNot);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

$productos = [];
$categorias = [];
$productosPorCategoria = [];
$noticias = [];

// Recorrer los resultados de productos y agrupar productos por categoría
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

// Procesar los resultados de noticias
foreach ($resultadosNot as $row) {
    if ($row['imagen']) {
        $row['imagen'] = base64_encode($row['imagen']);
    }
    $noticias[] = $row;
}

$jsonData = json_encode([
    "productos" => $productos,
    "categorias" => $categorias,
    "noticias" => $noticias
], JSON_PRETTY_PRINT);

$file = '../js/productos.json';
if (file_put_contents($file, $jsonData)) {
    echo "El archivo JSON se ha creado exitosamente: $file";
} else {
    echo "Error al crear el archivo JSON.";
}
