<!-- views/auth/login.php -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mi_tienda_virtual/views/templates/header.php'; ?>

<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="/mi_tienda_virtual/public/index.php?page=login&action=authenticate" method="POST">
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Iniciar Sesión</button>
    </form>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/mi_tienda_virtual/views/templates/footer.php'; ?>
