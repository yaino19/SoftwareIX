<?php
class Usuarios {
    private $conn;
    private $maxAttempts = 3;      // Máximo de intentos fallidos permitidos
    private $blockDuration = 900;  // Duración de bloqueo en segundos (15 minutos)

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Verifica si el usuario está bloqueado por intentos fallidos recientes
    public function estaBloqueado($usuario_id) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) as intentos 
             FROM IntentosSesion 
             WHERE usuario_id = ? 
               AND exito = 0 
               AND fecha_intento > (NOW() - INTERVAL ? SECOND)"
        );
        $stmt->bind_param("ii", $usuario_id, $this->blockDuration);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['intentos'] >= $this->maxAttempts;
    }

    public function registrarIntento($usuario_id, $exito, $ip) {
        $stmt = $this->conn->prepare("CALL RegistrarIntentoSesion(?, ?, ?)");
        $stmt->bind_param("iis", $usuario_id, $exito, $ip);
        $stmt->execute();
    }

    public function resetearIntentos($usuario_id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM IntentosSesion WHERE usuario_id = ? AND exito = 0"
        );
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
    }

    public function obtenerUsuarioPorCorreo($correo) {
        $stmt = $this->conn->prepare("SELECT * FROM Usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function registrarSesion($usuario_id, $ip, $user_agent) {
        $stmt = $this->conn->prepare("CALL RegistrarSesion(?, ?, ?)");
        $stmt->bind_param("iss", $usuario_id, $ip, $user_agent);
        $stmt->execute();
    }

    public function login($correo, $password, $ip, $user_agent) {
        $usuario = $this->obtenerUsuarioPorCorreo($correo);
        if (!$usuario) {
            return ['success' => false, 'message' => 'Usuario no encontrado'];
        }

        $usuario_id = $usuario['id'];

        if ($this->estaBloqueado($usuario_id)) {
            return ['success' => false, 'message' => 'Cuenta bloqueada por intentos fallidos. Intenta más tarde.'];
        }

        if (password_verify($password, $usuario['password'])) {
            $this->registrarIntento($usuario_id, 1, $ip);
            $this->resetearIntentos($usuario_id);
            $this->registrarSesion($usuario_id, $ip, $user_agent);
            return ['success' => true, 'usuario' => $usuario];
        } else {
            $this->registrarIntento($usuario_id, 0, $ip);
            return ['success' => false, 'message' => 'Contraseña incorrecta'];
        }
    }

        public function registrarUsuario($nombre, $apellido, $correo, $password) {
        $stmt = $this->conn->prepare("SELECT id FROM Usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return ['success' => false, 'message' => 'El correo ya está registrado.'];
        }
        $nombreCompleto = trim($nombre . ' ' . $apellido);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $tipoUsuarioId = 2; // usuario normal
        $uidGoogle = null;
        $stmt = $this->conn->prepare("CALL CrearUsuario(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $nombreCompleto, $correo, $hashedPassword, $tipoUsuarioId, $uidGoogle);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Usuario registrado exitosamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar el usuario.'];
        }
    }

    public function registrarGoogle($nombre, $correo, $uidGoogle, $tipoUsuarioId = 3) {
        $stmt = $this->conn->prepare("SELECT id FROM Usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return ['success' => false, 'message' => 'El correo ya está registrado. Puedes iniciar sesión.'];
        }
        $password = null;
        $stmt = $this->conn->prepare("CALL CrearUsuario(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $nombre, $correo, $password, $tipoUsuarioId, $uidGoogle);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Usuario registrado con Google.'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar con Google.'];
        }
    }
}
?>