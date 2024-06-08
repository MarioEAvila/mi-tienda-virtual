// controllers/LoginController.php
<?php
require_once '../models/Usuario.php';

class LoginController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function index() {
        require_once '../views/templates/header.php';
        require_once '../views/auth/login.php';
        require_once '../views/templates/footer.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $usuarioModel = new Usuario($this->conexion);
            $usuario = $usuarioModel->getUsuarioByEmail($email);

            if ($usuario ) {
                session_start();
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['rol'] = $usuario['rol']; // Asegúrate de que el rol se guarda en la sesión
                header('Location: /mi_tienda_virtual/public/index.php?page=dashboard');
                exit();
            } else {
                $error = "Credenciales incorrectas";
                require_once '../views/templates/header.php';
                require_once '../views/auth/login.php';
                require_once '../views/templates/footer.php';
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /mi_tienda_virtual/public/index.php?page=home');
        exit();
    }

    public function dashboard() {
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
