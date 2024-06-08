<?php
class Producto {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getProductosDestacados() {
        $sql = "SELECT p.*, u.username AS vendedor_nombre FROM productos p 
                JOIN usuario u ON p.vendedor_id = u.id_usuario WHERE p.destacado = 1";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllProductos() {
        $sql = "SELECT p.*, u.username AS vendedor_nombre FROM productos p 
                JOIN usuario u ON p.vendedor_id = u.id_usuario";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll();
    }

    public function getProductoById($id) {
        $sql = "SELECT p.*, u.username AS vendedor_nombre FROM productos p 
                JOIN usuario u ON p.vendedor_id = u.id_usuario WHERE p.id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createProducto($nombre, $descripcion, $precio, $stock, $imagen, $tipoImagen, $destacado, $vendedor_id) {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, tipo_imagen, destacado, vendedor_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $imagen, $tipoImagen, $destacado, $vendedor_id]);
        return $stmt->rowCount();
    }

    public function updateProducto($id, $nombre, $descripcion, $precio, $stock, $imagen, $tipoImagen, $destacado) {
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, imagen = ?, tipo_imagen = ?, destacado = ?
                WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $imagen, $tipoImagen, $destacado, $id]);
        return $stmt->rowCount();
    }

    public function deleteProducto($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
?>
