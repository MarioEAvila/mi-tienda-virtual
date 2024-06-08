// models/InformacionContacto.php
<?php
class InformacionContacto {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function crearInformacionContacto($usuario_id, $telefono, $direccion, $fecha_nacimiento, $imagen) {
        $stmt = $this->conexion->prepare("INSERT INTO informacion_contacto (usuario_id, telefono, direccion, fecha_nacimiento, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$usuario_id, $telefono, $direccion, $fecha_nacimiento, $imagen]);
    }
}
