<?php
/*if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: /mi_tienda_virtual/public/index.php?page=login');
    exit();
}*/
require_once '../views/templates/header.php';
require_once '../models/Producto.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $_FILES['imagen']['name'];
    $destacado = isset($_POST['destacado']) ? 1 : 0;
    $vendedor_id = $_SESSION['id_usuario'];

    // Subir la imagen al servidor
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($imagen);
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);

    $productoModel = new Producto($conexion);
    $productoModel->createProducto($nombre, $descripcion, $precio, $stock, $imagen, $destacado, $vendedor_id);
    header('Location: /mi_tienda_virtual/public/index.php?page=dashboard');
    exit();
}
?>

<div class="form-container">
    <h2>Publicar Nuevo Producto</h2>
    <form action="/mi_tienda_virtual/public/index.php?page=producto&action=publicarProducto" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre">Nombre del Producto</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required>
        </div>
        <?php if ($_SESSION['rol'] === 'administrador'): ?>
            <div class="form-group">
                <label for="destacado">Destacar</label>
                <input type="checkbox" id="destacado" name="destacado">
            </div>
        <?php endif; ?>
        <button type="submit">Publicar Producto</button>
    </form>
</div>

<?php require_once '../views/templates/footer.php'; ?>
