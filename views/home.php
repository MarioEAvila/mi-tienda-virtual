<?php require_once 'templates/header.php'; ?>

<div class="landing-container">
    <div class="hero-section">
        <div class="hero-content">
            <h1>Bienvenido a Mi Tienda Virtual</h1>
            <p>Encuentra los mejores productos al mejor precio.</p>
            <a href="#productos-destacados" class="btn">Ver Productos</a>
        </div>
    </div>
    <div id="productos-destacados" class="productos-destacados">
        <h2>Productos Destacados</h2>
        <div class="productos">
            <?php if (isset($productosDestacados) && !empty($productosDestacados)): ?>
                <?php foreach ($productosDestacados as $producto): ?>
                    <div class="producto">
                        <img src="../public/imagen.php?id=<?php echo htmlspecialchars($producto['id']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p>Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos destacados.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
