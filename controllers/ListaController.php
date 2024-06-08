<?php
require_once '../models/Lista.php';

class ListaController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;

        // Iniciar la sesión si no está ya iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
      header('Location: /mi_tienda_virtual/views/listas/listado.php');
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['id_usuario'])) {
                header('Location: /mi_tienda_virtual/public/index.php?page=login');
                exit();
            }

            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $publica = isset($_POST['publica']) ? 1 : 0;
            $usuario_id = $_SESSION['id_usuario'];
            
            // Manejo de la imagen
            $imagen = null;
            $tipo_imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = $_FILES['imagen']['name'];
                $rutaTemporal = $_FILES['imagen']['tmp_name'];
                $tipo_imagen = $_FILES['imagen']['type'];
                $imagen = file_get_contents($rutaTemporal); // Obtener el contenido de la imagen
                
                if (!$imagen) {
                    echo "Error al obtener el contenido del archivo subido.";
                }
            }

            $listaModel = new Lista($this->conexion);
            $listaModel->createLista($usuario_id, $nombre, $descripcion, $publica, $imagen, $tipo_imagen);

            header('Location: /mi_tienda_virtual/public/index.php?page=lista');
            exit();
        } else {
            require_once '../views/templates/header.php';
            require_once '../views/listas/crear.php';
            require_once '../views/templates/footer.php';
        }
    }

    public function agregarProducto() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $lista_id = $_GET['lista_id'];
            $producto_id = $_GET['producto_id'];
            $nombre = $_GET['nombre'];
            $descripcion = $_GET['descripcion'];
            $precio = $_GET['precio'];

            $listaModel = new Lista($this->conexion);
            $listaModel->addProductoToLista($lista_id, $producto_id, $nombre, $descripcion, $precio);

            header("Location: /mi_tienda_virtual/views/listas/detalle.php?id=$lista_id");
            exit();
        }
    }

    // Método para obtener listas
    public function obtenerListas() {
      $this->index();
    }

    public function obtenerListasArr() {
      if (!isset($_GET['id'])) {
        echo json_encode([]);
        exit();
      }

      $listaModel = new Lista($this->conexion);
      $listas = $listaModel->getAllListasByUsuario($_GET['id']);

      header('Content-Type: application/json');
      echo json_encode($listas);
    }
    
    public function detalle() {
      header('Location: /mi_tienda_virtual/views/listas/detalle.php?id='.$_GET['id']);
    }
    
    // Método para agregar producto a una lista
    public function agregarProductoALista() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lista_id = $_POST['lista_id'];
            $producto_id = $_POST['producto_id'];

            $listaModel = new Lista($this->conexion);
            $listaModel->addProductoToLista($lista_id, $producto_id);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Método no permitido']);
        }
    }

    // Método para quitar producto de una lista
    public function quitarProductoDeLista() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lista_id = $_POST['lista_id'];
            $producto_id = $_POST['producto_id'];

            $listaModel = new Lista($this->conexion);
            $listaModel->removeProductoFromLista($lista_id, $producto_id);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Método no permitido']);
        }
    }
}
?>
