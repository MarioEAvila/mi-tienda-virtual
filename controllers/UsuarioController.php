<?php
class UsuarioController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function login() {
        require_once '../views/templates/header.php';
        require_once '../views/auth/login.php';
        require_once '../views/templates/footer.php';
    }

    public function authenticate() {
        require_once '../models/Usuario.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $usuarioModel = new Usuario($this->conexion);
            $usuario = $usuarioModel->getUsuarioByEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                header('Location: /mi_tienda_virtual/public/index.php?page=home');
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
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $rol = $_POST['rol'];

            // Manejo de la imagen de perfil
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
                $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
            } else {
                $imagen = null;
            }

            $usuarioModel = new Usuario($this->conexion);
            $resultado = $usuarioModel->crearUsuario($username, $email, $password, $telefono, $direccion, $ciudad, $estado, $codigo_postal, $pais, $fecha_nacimiento, $imagen, $rol);

            if ($resultado) {
                echo "Usuario registrado con éxito.";
            } else {
                echo "Error al registrar el usuario.";
            }
        } else {
            require_once '../views/templates/header.php';
            require_once '../views/auth/register.php';
            require_once '../views/templates/footer.php';
        }
    }
}
