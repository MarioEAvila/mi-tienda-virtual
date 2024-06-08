// test_db_connection.php
<?php
require_once '../config/database.php';

$database = new Database();
$conexion = $database->connect();

if ($conexion) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar a la base de datos.";
}
?>
