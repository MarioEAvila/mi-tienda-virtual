<?php
class Carrito {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getCarritoByUsuarioId($usuario_id) {
        $query = "SELECT * FROM carrito WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createCarrito($usuario_id) {
        $query = "INSERT INTO carrito (usuario_id) VALUES (?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        return $stmt->execute();
    }

    public function addItemToCarrito($carrito_id, $producto_id, $cantidad) {
        // Verificar si el producto ya está en el carrito
        $query = "SELECT * FROM carrito_items WHERE carrito_id = ? AND producto_id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("ii", $carrito_id, $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        if ($item) {
            // Si el producto ya está en el carrito, actualizar la cantidad
            $query = "UPDATE carrito_items SET cantidad = cantidad + ? WHERE id = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("ii", $cantidad, $item['id']);
        } else {
            // Si el producto no está en el carrito, insertarlo
            $query = "INSERT INTO carrito_items (carrito_id, producto_id, cantidad) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("iii", $carrito_id, $producto_id, $cantidad);
        }
        return $stmt->execute();
    }

    public function getCantidadProductos($carrito_id) {
        $query = "SELECT SUM(cantidad) AS total_cantidad FROM carrito_items WHERE carrito_id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $carrito_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total_cantidad'] ?? 0;
    }
}
?>
