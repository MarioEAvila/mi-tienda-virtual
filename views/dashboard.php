<!-- views/dashboard.php -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /mi_tienda_virtual/public/index.php?page=login');
    exit();
}
require_once '../views/templates/header.php';
require_once '../models/Producto.php';
require_once '../config/database.php'; // Asegúrate de tener este archivo configurado correctamente

$database = new Database();
$conexion = $database->connect();

$productoModel = new Producto($conexion);
?>

<div class="dashboard-container">
    <aside class="sidebar">
        <form action="/mi_tienda_virtual/public/index.php?page=dashboard" method="GET">
            <input type="hidden" name="page" value="dashboard">
            <input type="text" name="search" placeholder="Buscar productos...">
            <button type="submit">Buscar</button>
        </form>
        <ul>
            <li><a href="/mi_tienda_virtual/public/index.php?page=lista&action=obtenerListas">Mis Listas</a></li>
            <li><a href="/mi_tienda_virtual/public/index.php?page=lista&action=crear">Crear Lista</a></li>
            <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 'vendedor' || $_SESSION['rol'] == 'administrador')): ?>
                <li><a href="/mi_tienda_virtual/public/index.php?page=producto&action=publicarProducto">Publicar Producto</a></li>
            <?php endif; ?>
        </ul>
    </aside>
    <main class="content">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['id_usuario']); ?>!</h2>
        <p>Esta es tu página de inicio personalizada.</p>

        <?php
        try {
            $productos = $productoModel->getAllProductos();
            if ($productos && count($productos) > 0): ?>
                <div class="productos-container">
                    <?php foreach ($productos as $producto): ?>
                        <div class="producto">
                            <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="producto-imagen">
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p>Precio: <?php echo htmlspecialchars($producto['precio']); ?></p>
                            <button class="btn-agregar-lista" data-producto-id="<?php echo $producto['id']; ?>">Agregar a Lista</button>
                            <button class="btn-agregar-carrito" data-producto-id="<?php echo $producto['id']; ?>">Agregar al Carrito</button> <!-- Nuevo botón para agregar al carrito -->
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif;
        } catch (Exception $e) {
            echo "Error al obtener productos: " . $e->getMessage();
        }
        ?>
    </main>
</div>

<!-- Modal -->
<div class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <!-- Aquí se cargarán las listas del usuario -->
    </div>
</div>

<?php require_once '../views/templates/footer.php'; ?>
<script src="/mi_tienda_virtual/public/js/modal.js"></script>
<script>
function agregarAlCarrito(productoId) {
    fetch('/mi_tienda_virtual/controllers/CarritoController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'producto_id=' + productoId
    })
    .then(response => response.json())
    .then(data => {
        if (data.total_cantidad !== undefined) {
            document.getElementById('carrito-cantidad').innerText = data.total_cantidad;
        } else if (data.error) {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => console.error('Error adding to cart:', error));
}

document.querySelectorAll('.btn-agregar-carrito').forEach(button => {
    button.addEventListener('click', () => {
        const productoId = button.getAttribute('data-producto-id');
        agregarAlCarrito(productoId);
    });
});
</script>
