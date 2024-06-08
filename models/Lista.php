<?php
class Lista {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getAllListasByUsuario($usuario_id) {
        $sql = "SELECT * FROM listas WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll();
    }

    public function createLista($usuario_id, $nombre, $descripcion, $publica, $imagen, $tipo_imagen) {
        $sql = "INSERT INTO listas (usuario_id, nombre, descripcion, publica, imagen, tipo_imagen) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario_id, $nombre, $descripcion, $publica, $imagen, $tipo_imagen]);
        return $stmt->rowCount();
    }

    public function addProductoToLista($lista_id, $producto_id, $nombre, $descripcion, $precio) {
        $sql = "INSERT INTO listas_productos(lista_id, producto_id, nombre, descripcion, precio) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$lista_id, $producto_id, $nombre, $descripcion, $precio]);
        return $stmt->rowCount();
    }

    public function getListaById($lista_id) {
      $sql = "SELECT * FROM listas WHERE id = ?";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute([$lista_id]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductosByLista($lista_id) {
        $sql = "SELECT * FROM listas_productos WHERE lista_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$lista_id]);
        return $stmt->fetchAll();
    }
}
?>
