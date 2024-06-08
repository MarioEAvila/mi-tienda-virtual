<!-- views/dashboard.php -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /mi_tienda_virtual/public/index.php?page=login');
    exit();
}

require_once '../../views/templates/header.php';
require_once '../../models/Producto.php';
require_once '../../config/database.php'; // Asegúrate de tener este archivo configurado correctamente

$database = new Database();
$conexion = $database->connect();

$productoModel = new Producto($conexion);
?>

<div class="container">
    <h2>Mi carrito</h2>
    <hr>
    <?php
        try {
            $productos = $productoModel->getProductosByCart($_SESSION['id_usuario']);
            if ($productos && count($productos) > 0): ?>
                <div class="list-group">
                  <table>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                    <?php $total = 0; ?>
                    <?php foreach ($productos as $producto): ?>
                        <?php $total += $producto["precio"] * $producto["cantidad"]; ?>
                        <tr>
                            <td> <img src="<?php echo '../'.$producto['imagen']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="carrito-imagen"> </td>
                            <td> <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3> </td>
                            <td> <p><?php echo htmlspecialchars($producto['descripcion']); ?></p> </td>
                            <td> <p><?php echo htmlspecialchars($producto['precio']); ?></p> </td>
                            <td> <p><?php echo htmlspecialchars($producto['cantidad']); ?></p> </td>
                        </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
                <div class="carrito-total">
                  Total: $<?php echo $total; ?>
                </div>
                <div id="paypal-button-container">
                </div>
                <script>
                  window.paypal
                    .Buttons({
                      style: {
                        shape: 'rect',
                        //color:'blue', change the default color of the buttons
                        layout: 'vertical', //default value. Can be changed to horizontal
                      },
                    })
                    .render("#paypal-button-container");
                </script>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif;
        } catch (Exception $e) {
            echo "Error al obtener productos: " . $e->getMessage();
        }
        ?>
</div>

<?php require_once '../../views/templates/footer.php'; ?>
