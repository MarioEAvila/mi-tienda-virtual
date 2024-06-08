<?php
class DashboardController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function index() {
        header('Location: /mi_tienda_virtual/views/dashboard.php');
    }
}
?>
