<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mi_tienda_virtual/views/templates/header.php'; ?>

<div class="container">
    <h2>Crear Nueva Lista</h2>
    <form action="/mi_tienda_virtual/public/index.php?page=lista&action=crear" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre">Nombre de la Lista:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
        </div>
        
        <div class="form-group form-check">
            <input type="checkbox" id="publica" name="publica" class="form-check-input">
            <label for="publica" class="form-check-label">¿Es pública?</label>
        </div>
        
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" class="form-control-file" accept="image/*">
        </div>
        
        <button type="submit" class="btn btn-primary">Crear Lista</button>
    </form>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mi_tienda_virtual/views/templates/footer.php'; ?>
