<!-- views/dashboard.php -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: /mi_tienda_virtual/public/index.php?page=login');
    exit();
}

if (!isset($_GET['id'])) {
  header('Location: /mi_tienda_virtual/public/index.php?page=dashboard');
  exit();
}

require_once '../../views/templates/header.php';
require_once '../../models/Producto.php';
require_once '../../models/Lista.php';
require_once '../../config/database.php'; // Asegúrate de tener este archivo configurado correctamente

$database = new Database();
$conexion = $database->connect();

$productoModel = new Producto($conexion);
$listaModel = new Lista($conexion);

$lista = $listaModel->getListaById($_GET['id']);
if (!isset($lista)) {
  header('Location: /mi_tienda_virtual/public/index.php?page=dashboard');
  exit();
}
?>

<div class="container">
    <h2><?php echo $lista["nombre"] ?></h2>
    <p><?php echo $lista["descripcion"] ?></p>
    <hr>
    <?php
      try {
          $productos = $productoModel->getProductosByLista($_GET['id']);
          if ($productos && count($productos) > 0): ?>
              <div class="list-group">
                <table>
                  <tr>
                      <th>Imagen</th>
                      <th>Nombre</th>
                      <th>Descripcion</th>
                      <th>Precio</th>
                  </tr>
                  <?php foreach ($productos as $producto): ?>
                      <tr>
                          <td> <img src="<?php echo '../'.$producto['imagen']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="carrito-imagen"> </td>
                          <td> <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3> </td>
                          <td> <p><?php echo htmlspecialchars($producto['descripcion']); ?></p> </td>
                          <td> <p><?php echo htmlspecialchars($producto['precio']); ?></p> </td>
                      </tr>
                  <?php endforeach; ?>
                </table>
              </div>
          <?php else: ?>
              <p>No hay productos disponibles.</p>
          <?php endif;
      } catch (Exception $e) {
          echo "Error al obtener productos: " . $e->getMessage();
      }
    ?>
</div>

<?php require_once '../../views/templates/footer.php'; ?>
