<?php
require_once '../models/Usuario.php';

class RegisterController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para mostrar el formulario de registro
    public function index() {
        require_once '../views/templates/header.php';
        require_once '../views/auth/register.php';
        require_once '../views/templates/footer.php';
    }

    // Método para procesar el formulario de registro
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $ciudad = $_POST['ciudad'];
            $estado = $_POST['estado'];
            $codigo_postal = $_POST['codigo_postal'];
            $pais = $_POST['pais'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $rol = $_POST['rol'];

            $usuarioModel = new Usuario($this->conexion);
        try {
            $usuarioModel->crearUsuario($username, $email, $password, $telefono, $direccion, $ciudad, $estado, $codigo_postal, $pais, $fecha_nacimiento, $imagen, $rol);
            header('Location: /mi_tienda_virtual/public/index.php?page=login');
            exit(); // Asegúrate de usar exit() después de la redirección
        } catch (Exception $e) {
            // Manejar el error apropiadamente
            $error = "Error al registrar el usuario: " . $e->getMessage();
            require_once '../views/templates/header.php';
            require_once '../views/auth/register.php';
            require_once '../views/templates/footer.php';
            }
        }
    }
}
