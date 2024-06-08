<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mi_tienda_virtual/views/templates/header.php'; ?>

<div class="container">
    <h2>Mis Listas</h2>
    <ul class="list-group">
        <?php if (!empty($listas)) : ?>
            <?php foreach ($listas as $lista) : ?>
                <li class="list-group-item">
                    <?php if ($lista['imagen']) : ?>
                        <img src="data:<?php echo $lista['tipo_imagen']; ?>;base64,<?php echo base64_encode($lista['imagen']); ?>" alt="Imagen de la lista">
                    <?php endif; ?>
                    <div>
                        <h4><?php echo htmlspecialchars($lista['nombre']); ?></h4>
                        <p><?php echo htmlspecialchars($lista['descripcion']); ?></p>
                        <a href="/mi_tienda_virtual/public/index.php?page=lista&action=detalle&id=<?php echo $lista['id']; ?>" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No tienes listas creadas.</p>
        <?php endif; ?>
    </ul>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mi_tienda_virtual/views/templates/footer.php'; ?>
