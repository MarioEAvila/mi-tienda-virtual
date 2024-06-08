<?php
class Usuario {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function crearUsuario($username, $email, $password, $telefono, $direccion, $ciudad, $estado, $codigo_postal, $pais, $fecha_nacimiento, $imagen, $rol) {
        try {
            // Iniciar una transacción
            $this->conexion->beginTransaction();

            // Insertar en la tabla usuario
            $sqlUsuario = "INSERT INTO usuario (username, email, password, rol) VALUES (:username, :email, :password, :rol)";
            $stmtUsuario = $this->conexion->prepare($sqlUsuario);
            $stmtUsuario->bindParam(':username', $username);
            $stmtUsuario->bindParam(':email', $email);
            $stmtUsuario->bindParam(':password', $password);
            $stmtUsuario->bindParam(':rol', $rol);
            $stmtUsuario->execute();
            
            // Obtener el ID del usuario recién insertado
            $usuarioId = $this->conexion->lastInsertId();

            // Insertar en la tabla informacion_contacto
            $sqlInfo = "INSERT INTO informacion_contacto (id_usuario, telefono, direccion, ciudad, estado, codigo_postal, pais, fecha_nacimiento, imagen) VALUES (:id_usuario, :telefono, :direccion, :ciudad, :estado, :codigo_postal, :pais, :fecha_nacimiento, :imagen)";
            $stmtInfo = $this->conexion->prepare($sqlInfo);
            $stmtInfo->bindParam(':id_usuario', $usuarioId);
            $stmtInfo->bindParam(':telefono', $telefono);
            $stmtInfo->bindParam(':direccion', $direccion);
            $stmtInfo->bindParam(':ciudad', $ciudad);
            $stmtInfo->bindParam(':estado', $estado);
            $stmtInfo->bindParam(':codigo_postal', $codigo_postal);
            $stmtInfo->bindParam(':pais', $pais);
            $stmtInfo->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $stmtInfo->bindParam(':imagen', $imagen, PDO::PARAM_LOB); // Almacena la imagen como un LOB
            $stmtInfo->execute();

            // Confirmar la transacción
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conexion->rollBack();
            throw $e;
        }
    }

    public function getUsuarioByEmail($email) {
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
