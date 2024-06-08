<?php
session_start(); // Iniciar la sesión

require_once '../config/database.php';
require_once '../models/Carrito.php';

class CarritoController {
    private $conexion;
    private $carritoModel;

    public function __construct() {
        $database = new Database();
        $this->conexion = $database->connect();
        $this->carritoModel = new Carrito($this->conexion);
    }

    public function index() {
      header('Location: /mi_tienda_virtual/views/carrito/listado.php');
    }

    public function agregarAlCarrito() {
        if (!isset($_SESSION['id_usuario'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario no autenticado']);
            exit();
        }

        $usuario_id = $_SESSION['id_usuario'];
        $producto_id = $_POST['producto_id'];
        $cantidad = 1; // Puedes modificar esta cantidad según sea necesario

        // Verificar si el usuario tiene un carrito existente
        $carrito = $this->carritoModel->getCarritoByUsuarioId($usuario_id);
        if (!$carrito) {
            // Crear un nuevo carrito para el usuario
            $this->carritoModel->createCarrito($usuario_id);
            $carrito = $this->carritoModel->getCarritoByUsuarioId($usuario_id);
        }

        $carrito_id = $carrito['id'];
        $this->carritoModel->addItemToCarrito($carrito_id, $producto_id, $cantidad);

        // Obtener la cantidad actual de productos en el carrito
        $total_cantidad = $this->carritoModel->getCantidadProductos($carrito_id);

        header('Content-Type: application/json');
        echo json_encode(['total_cantidad' => $total_cantidad]);
    }

    public function obtenerCantidadProductos() {
        if (!isset($_SESSION['id_usuario'])) {
            header('Content-Type: application/json');
            echo json_encode(['total_cantidad' => 0]);
            exit();
        }

        $usuario_id = $_SESSION['id_usuario'];
        $carrito = $this->carritoModel->getCarritoByUsuarioId($usuario_id);
        if ($carrito) {
            $carrito_id = $carrito['id'];
            $total_cantidad = $this->carritoModel->getCantidadProductos($carrito_id);
        } else {
            $total_cantidad = 0;
        }

        header('Content-Type: application/json');
        echo json_encode(['total_cantidad' => $total_cantidad]);
    }
}
?>