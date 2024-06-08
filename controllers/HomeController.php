<?php
require_once '../models/Producto.php';

class HomeController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function index() {
        $productoModel = new Producto($this->conexion);
        $productosDestacados = $productoModel->getProductosDestacados();
        require_once '../views/templates/header.php';
        require_once '../views/home.php';
        require_once '../views/templates/footer.php';
    }
}
?>
