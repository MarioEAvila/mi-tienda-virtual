<?php
require_once '../models/Producto.php';

class ProductoController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
        
        // Iniciar la sesión si no está ya iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $productoModel = new Producto($this->conexion);
        $productos = $productoModel->getAllProductos();
        
        require_once '../views/templates/header.php';
        require_once '../views/productos/listado.php';
        require_once '../views/templates/footer.php';
    }

    public function show($id) {
        $productoModel = new Producto($this->conexion);
        $producto = $productoModel->getProductoById($id);
        
        require_once '../views/templates/header.php';
        require_once '../views/productos/detalle.php';
        require_once '../views/templates/footer.php';
    }

    public function publicarProducto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $destacado = isset($_POST['destacado']) ? 1 : 0;
            $vendedor_id = $_SESSION['id_usuario'];

            // Verificar si el usuario tiene permisos de administrador para destacar productos
            if ($destacado && $_SESSION['rol'] !== 'administrador') {
                $destacado = 0; // No permitir destacar si no es administrador
            }

            // Manejo de la imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = $_FILES['imagen']['name'];
                $tipoImagen = $_FILES['imagen']['type'];
                $rutaTemporal = $_FILES['imagen']['tmp_name'];

                $rutaDestino = '../uploads/' . $nombreImagen;

                // Verificar si el directorio de destino existe, si no, crearlo
                if (!is_dir('../uploads')) {
                    mkdir('../uploads', 0777, true);
                }

                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    // Guardar la información del producto en la base de datos
                    $productoModel = new Producto($this->conexion);
                    $productoModel->createProducto($nombre, $descripcion, $precio, $stock, $rutaDestino, $tipoImagen, $destacado, $vendedor_id);
                    
                    // Redirigir al dashboard después de un registro exitoso
                    header('Location: /mi_tienda_virtual/public/index.php?page=producto&action=dashboard');
                    exit();
                } else {
                    echo "Error al mover el archivo subido.";
                }
            } else {
                echo "Error en la subida del archivo.";
            }
        } else {
            require_once '../views/templates/header.php';
            require_once '../views/productos/publicar_producto.php';
            require_once '../views/templates/footer.php';
        }
    }

    public function dashboard() {
        $productoModel = new Producto($this->conexion);
        $productos = $productoModel->getAllProductos();
        
        require_once '../views/templates/header.php';
        require_once '../views/dashboard.php';
        require_once '../views/templates/footer.php';
    }
}
?>
