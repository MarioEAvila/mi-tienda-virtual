<?php
require_once '../config/config.php';

// Verificar si el parámetro id está presente en la URL y es numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Consulta para obtener la imagen y su tipo
    $stmt = $conexion->prepare('SELECT imagen, tipo_imagen FROM productos WHERE id = ?');
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        // Si se encuentra el producto, enviar la cabecera correcta y mostrar la imagen
        header('Content-Type: ' . $producto['tipo_imagen']);
        echo $producto['imagen'];
    } else {
        // Si no se encuentra la imagen, mostrar un mensaje de error
        http_response_code(404);
        echo 'Imagen no encontrada';
    }
} else {
    // Si no se proporciona un ID válido, mostrar un mensaje de error
    http_response_code(400);
    echo 'ID no proporcionado o inválido';
    echo '<pre>';
    print_r($_GET); // Mostrar el contenido de $_GET para depuración
    echo '</pre>';
}
?>
