<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mi_tienda_virtual/views/templates/header.php'; ?>

<div class="register-container">
    <h2>Registro de Usuario</h2>
    <form action="/mi_tienda_virtual/public/index.php?page=register&action=store" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" required>
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal:</label>
            <input type="text" id="codigo_postal" name="codigo_postal" required>
        </div>
        <div class="form-group">
            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais" required>
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen de Perfil:</label>
            <input type="file" id="imagen" name="imagen">
        </div>
        <div class="form-group">
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="cliente">Cliente</option>
                <option value="vendedor">Vendedor</option>
                <option value="administrador">Administrador</option>
            </select>
        </div>
        <button type="submit">Registrarse</button>
    </form>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mi_tienda_virtual/views/templates/footer.php'; ?>
