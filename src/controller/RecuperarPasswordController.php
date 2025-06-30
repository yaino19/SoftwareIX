<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RecuperarPasswordController {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function solicitarRecuperacion($correo) {
        if (empty($correo)) {
            return ['success' => false, 'message' => 'El correo es requerido.'];
        }
        // Buscar usuario
        $stmt = $this->conn->prepare('SELECT id FROM usuarios WHERE correo = ?');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'El correo no está registrado. Por favor verifica tu dirección.'];
        }
        $user = $result->fetch_assoc();
        $codigo = rand(100000, 999999);
        $stmt2 = $this->conn->prepare('REPLACE INTO recuperacion_password (user_id, codigo, creado_en) VALUES (?, ?, NOW())');
        $stmt2->bind_param('is', $user['id'], $codigo);
        $stmt2->execute();
        
        // Enviar el código por email usando PHPMailer
        require_once __DIR__ . '/../../vendor/autoload.php';
        $mail = new PHPMailer(true);
        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp-mail.outlook.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jason.arena@utp.ac.pa';
            $mail->Password = 'ThePana27278_utp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // Remitente y destinatario
            $mail->setFrom('jason.arena@utp.ac.pa', 'Sistema de Notificaciones');
            $mail->addAddress($correo);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Código de recuperación de contraseña';
            $mail->Body    = '<p>Hola,</p><p>Tu código de recuperación es: <b>' . $codigo . '</b></p><p>Este código es válido por 15 minutos.</p>';
            $mail->AltBody = 'Tu código de recuperación es: ' . $codigo . '. Este código es válido por 15 minutos.';

            $mail->send();
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'No se pudo enviar el correo de recuperación a ' . htmlspecialchars($correo) . '. Error: ' . $mail->ErrorInfo
            ];
        }
        // Siempre devolver éxito aunque falle el envío, para permitir avanzar en el flujo (solo para pruebas)
        return [
            'success' => true,
            'message' => 'Se ha enviado un correo con el código de recuperación a ' . htmlspecialchars($correo) . '. Revisa tu bandeja de entrada o spam.'
        ];
    }

    public function verificarCodigo($correo, $codigo) {
        $stmt = $this->conn->prepare('SELECT id FROM usuarios WHERE correo = ?');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'Correo no válido.'];
        }
        $user = $result->fetch_assoc();
        $stmt2 = $this->conn->prepare('SELECT * FROM recuperacion_password WHERE user_id = ? AND codigo = ? AND TIMESTAMPDIFF(MINUTE, creado_en, NOW()) < 15');
        $stmt2->bind_param('is', $user['id'], $codigo);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows === 0) {
            return ['success' => false, 'message' => 'Código incorrecto o expirado.'];
        }
        return ['success' => true, 'message' => 'Código verificado.'];
    }

    public function cambiarContrasena($correo, $nuevaContrasena) {
        $stmt = $this->conn->prepare('SELECT id FROM usuarios WHERE correo = ?');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'Correo no válido.'];
        }
        $user = $result->fetch_assoc();
        $hash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $stmt2 = $this->conn->prepare('UPDATE usuarios SET password = ? WHERE id = ?');
        $stmt2->bind_param('si', $hash, $user['id']);
        $stmt2->execute();
        // Eliminar el código usado
        $stmt3 = $this->conn->prepare('DELETE FROM recuperacion_password WHERE user_id = ?');
        $stmt3->bind_param('i', $user['id']);
        $stmt3->execute();
        return [
            'success' => true,
            'message' => 'Contraseña actualizada correctamente.',
            'redirect' => '/SoftwareIX/public/assets/login.php'
        ];
    }
}
