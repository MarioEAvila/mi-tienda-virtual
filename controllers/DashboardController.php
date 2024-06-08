// controllers/DashboardController.php
<?php
class DashboardController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /mi_tienda_virtual/public/index.php?page=login');
            exit();
        }
        require_once '../views/templates/header.php';
        require_once '../views/dashboard.php';
        require_once '../views/templates/footer.php';
    }
}
?>
