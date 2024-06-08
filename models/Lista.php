<?php
class Lista {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getAllListasByUsuario($usuario_id) {
        $sql = "SELECT * FROM listas WHERE usuario_id = :usuario_id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Depuración: Log para verificar el contenido de $result
        error_log("Resultados de la consulta: " . print_r($result, true));
    
        return $result;
    }
    
    

    public function createLista($usuario_id, $nombre, $descripcion, $publica, $imagen, $tipo_imagen) {
        $sql = "INSERT INTO listas (usuario_id, nombre, descripcion, publica, imagen, tipo_imagen) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario_id, $nombre, $descripcion, $publica, $imagen, $tipo_imagen]);
        return $stmt->rowCount();
    }

    public function addProductoToLista($lista_id, $producto_id, $nombre, $descripcion, $precio) {
        $sql = "INSERT INTO listas_productos (lista_id, producto_id, nombre, descripcion, precio) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$lista_id, $producto_id, $nombre, $descripcion, $precio]);
        return $stmt->rowCount();
    }

    public function getProductosByLista($lista_id) {
        $sql = "SELECT * FROM listas_productos WHERE lista_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$lista_id]);
        return $stmt->fetchAll();
    }
}
?>
