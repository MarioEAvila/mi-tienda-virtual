<?php
session_start(); // Inicia la sesión

class ListaController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function index() {
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /mi_tienda_virtual/public/index.php?page=login');
            exit();
        }

        require_once '../models/Lista.php';

        $listaModel = new Lista($this->conexion);
        $listas = $listaModel->getAllListasByUsuario($_SESSION['id_usuario']);
        
        require_once '../views/templates/header.php';
        require_once '../views/listas/listado.php';
        require_once '../views/templates/footer.php';
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

            require_once '../models/Lista.php';
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lista_id = $_POST['lista_id'];
            $producto_id = $_POST['producto_id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];

            require_once '../models/Lista.php';
            $listaModel = new Lista($this->conexion);
            $listaModel->addProductoToLista($lista_id, $producto_id, $nombre, $descripcion, $precio);

            header('Location: /mi_tienda_virtual/public/index.php?page=lista');
            exit();
        }
    }

    // Método para obtener listas
    public function obtenerListas() {
        if (!isset($_SESSION['id_usuario'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario no autenticado']);
            exit();
        }
    
        require_once '../models/Lista.php';
    
        $listaModel = new Lista($this->conexion);
        $listas = $listaModel->getAllListasByUsuario($_SESSION['id_usuario']);
    
        // Depuración: Log para verificar el contenido de $listas
        error_log("Listas obtenidas: " . print_r($listas, true));
    
        header('Content-Type: application/json');
        echo json_encode($listas);
    }      
    
    // Método para agregar producto a una lista
    public function agregarProductoALista() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lista_id = $_POST['lista_id'];
            $producto_id = $_POST['producto_id'];

            require_once '../models/Lista.php';
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

            require_once '../models/Lista.php';
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
