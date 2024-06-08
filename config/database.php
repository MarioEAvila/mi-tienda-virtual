<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'usuarios_be';
    private $username = 'root';
    private $password = '';
    public $conexion;

    public function connect() {
        $this->conexion = null;

        try {
            $this->conexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conexion;
    }
}
?>
