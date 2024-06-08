<!-- views/dashboard.php -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /mi_tienda_virtual/public/index.php?page=login');
    exit();
}
// product id
if (!isset($_GET['id'])) {
  header('Location: /mi_tienda_virtual/public/index.php?page=dashboard');
  exit();
}
require_once '../../views/templates/header.php';
require_once '../../models/Lista.php';
require_once '../../config/database.php'; // Asegúrate de tener este archivo configurado correctamente

$database = new Database();
$conexion = $database->connect();

$listasModel = new Lista($conexion);
$listas = $listasModel->getAllListasByUsuario($_SESSION['id_usuario']);
?>

<div class="container">
    <h2>Mis Listas</h2>
    <?php if (!empty($listas)) : ?>
      <form action='/mi_tienda_virtual/public/index' method='GET'>
          <ul class="list-group">
            <?php foreach ($listas as $lista) : ?>
                <li class="list-group-item">
                    <div>
                      <input type="radio" name="lista_id"  value=<?=$lista["id"]?>>
                      <label for="lista_<?=$lista["id"]?>"><?=$lista["nombre"]?></label>
                    </div>
                </li>
            <?php endforeach; ?>
          </ul>
              
          <!-- controller and action -->
          <input type="hidden" name="page" value="lista">
          <input type="hidden" name="action" value="agregarProducto">
          
          <input type="hidden" name="producto_id" value=<?=$_GET["id"]?> >

          <div style="margin-top: 20px">
            <label style="display: block" for='nombre-text'> Nombre </label>
            <input id='nombre-text' type='text' name='nombre'>
          </div>

          <div style="margin-top: 20px">
            <label style="display: block" for='descripcion-text'> Descripcion </label>
            <input id='descripcion-text' type='text' name='descripcion'>
          </div>

          
          <div style="margin-top: 20px">
            <label style="display: block"  for='precio-num'> Precio </label>
            <input id='precio-num' type='number' name='precio'>
          </div>

        <button style="margin-top: 20px"> Enviar </button>
      </form>
    <?php else : ?>
        <p>No tienes listas creadas.</p>
    <?php endif; ?>
</div>

<?php require_once '../../views/templates/footer.php'; ?>
