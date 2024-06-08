<?php
class Carrito {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getCarritoByUsuarioId($usuario_id) {
        $query = "SELECT * FROM carrito WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCarrito($usuario_id) {
        $query = "INSERT INTO carrito (usuario_id) VALUES (?)";
        $stmt = $this->conexion->prepare($query);
        return $stmt->execute([$usuario_id]);
    }

    public function addItemToCarrito($carrito_id, $producto_id, $cantidad) {
        // Verificar si el producto ya está en el carrito
        $query = "SELECT * FROM carrito_items WHERE carrito_id = ? AND producto_id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute([$carrito_id, $producto_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        $result = false;
        if ($item) {
            // Si el producto ya está en el carrito, actualizar la cantidad
            $query = "UPDATE carrito_items SET cantidad = cantidad + ? WHERE id = ?";
            $stmt = $this->conexion->prepare($query);
            $result = $stmt->execute([$cantidad, $item['id']]);
        } else {
            // Si el producto no está en el carrito, insertarlo
            $query = "INSERT INTO carrito_items (carrito_id, producto_id, cantidad) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $result = $stmt->execute([$carrito_id, $producto_id, $cantidad]);
        }
        return $result;
    }

    public function getCantidadProductos($carrito_id) {
        $query = "SELECT SUM(cantidad) AS total_cantidad FROM carrito_items WHERE carrito_id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute([$carrito_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_cantidad'] ?? 0;
    }
}
?>
