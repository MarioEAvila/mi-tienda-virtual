<!-- views/templates/navbar.php -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <ul>
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <li><a href="/mi_tienda_virtual/public/index.php?page=logout">Cerrar Sesión</a></li>
            <li><a href="/mi_tienda_virtual/public/index.php?page=dashboard">Dashboard</a></li>
            <li>
                <a href="/mi_tienda_virtual/public/index.php?page=carrito">
                    Carrito de Compras (<span id="carrito-cantidad">0</span>)
                </a>
            </li>
            <li><a href="/mi_tienda_virtual/public/index.php?page=lista">Mis Listas</a></li>
            <li><a href="/mi_tienda_virtual/public/index.php?page=lista&action=crear">Crear Lista</a></li> <!-- Agregando la opción para crear una lista -->
            <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 'vendedor' || $_SESSION['rol'] == 'administrador')): ?>
                <li><a href="/mi_tienda_virtual/public/index.php?page=producto&action=publicarProducto">Publicar Producto</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="/mi_tienda_virtual/public/index.php?page=home">Inicio</a></li>
            <li><a href="/mi_tienda_virtual/public/index.php?page=login">Iniciar Sesión</a></li>
            <li><a href="/mi_tienda_virtual/public/index.php?page=register">Registrarse</a></li>
        <?php endif; ?>
        <li id="weather-time"></li> <!-- Agregando el lugar para la hora y el clima -->
    </ul>
</nav>

<script>
    // Obtener la cantidad de productos en el carrito al cargar la página
    fetch('/mi_tienda_virtual/public/index.php?page=carrito&action=obtenerCantidadProductos')
        .then(response => response.json())
        .then(data => {
            document.getElementById('carrito-cantidad').innerText = data.total_cantidad;
        })
        .catch(error => console.error('Error fetching cart quantity:', error));
</script>