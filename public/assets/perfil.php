<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');

$filtro_nombre = null;
if (isset($_SESSION['usuario_id'])) {
    $conn = new mysqli($host, $username, $password, $database);
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("SELECT id, nombre, correo, tipo_usuario_id FROM Usuarios WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['usuario_id']);
        $stmt->execute();
        $stmt->bind_result($id, $nombre, $correo, $tipo_usuario_id);
        if ($stmt->fetch()) {
            $filtro_id = $id;
            $filtro_nombre = $nombre;
            $filtro_correo = $correo;
            $filtro_tipo = ($tipo_usuario_id == 1) ? 'Admin' : (($tipo_usuario_id == 2) ? 'Usuario del sistema' : 'Google');
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<div class="profile-section" id="perfil-content">
  <div class="container">
    <div class="profile-content">
      <div class="profile-card">
        <img src="https://via.placeholder.com/120x120" alt="Avatar" class="profile-avatar">
        <div class="profile-name"><?php echo isset($filtro_nombre) ? htmlspecialchars($filtro_nombre) : ''; ?></div>
        <div class="profile-email"><?php echo isset($filtro_correo) ? htmlspecialchars($filtro_correo) : ''; ?></div>
        <button class="edit-btn"><i class="fas fa-edit"></i> Editar Perfil</button>
      </div>
      <div class="profile-details">
        <div class="profile-tabs">
          <button class="tab-btn active" onclick="showTab('info', event)">Información Personal</button>
          <button class="tab-btn" onclick="showTab('notifications', event)">Notificaciones</button>
        </div>
        <div id="info" class="tab-content active">
          <div class="info-grid">
            <div class="info-item">
              <div class="info-label">Nombre Completo</div>
              <div class="info-value"><?php echo isset($filtro_nombre) ? htmlspecialchars($filtro_nombre) : ''; ?></div>
            </div>
            <div class="info-item">
              <div class="info-label">ID</div>
              <div class="info-value"><?php echo isset($filtro_id) ? $filtro_id : ''; ?></div>
            </div>
            <div class="info-item">
              <div class="info-label">Correo</div>
              <div class="info-value"><?php echo isset($filtro_correo) ? htmlspecialchars($filtro_correo) : ''; ?></div>
            </div>
            <div class="info-item">
              <div class="info-label">Tipo Usuario</div>
              <div class="info-value"><?php echo isset($filtro_tipo) ? $filtro_tipo : ''; ?></div>
            </div>
          </div>
        </div>
        <div id="orders" class="tab-content">
          <div class="notification-item">
            <i class="fas fa-box notification-icon"></i>
            <div>
              <strong>Pedido #001</strong>
              <p>Chaqueta UTP - Entregado el 15 de Julio</p>
            </div>
          </div>
          <div class="notification-item">
            <i class="fas fa-box notification-icon"></i>
            <div>
              <strong>Pedido #002</strong>
              <p>Gorra y Termo UTP - En camino</p>
            </div>
          </div>
          <div class="notification-item">
            <i class="fas fa-box notification-icon"></i>
            <div>
              <strong>Pedido #003</strong>
              <p>Llavero UTP - Procesando</p>
            </div>
          </div>
        </div>
        <div id="notifications" class="tab-content">
          <div class="notification-item">
            <i class="fas fa-bell notification-icon"></i>
            <div>
              <strong>Nuevo producto disponible</strong>
              <p>Sudadera UTP edición limitada</p>
            </div>
          </div>
          <div class="notification-item">
            <i class="fas fa-tag notification-icon"></i>
            <div>
              <strong>Descuento especial</strong>
              <p>20% off en toda la tienda - Válido hasta el 31 de julio</p>
            </div>
          </div>
          <div class="notification-item">
            <i class="fas fa-truck notification-icon"></i>
            <div>
              <strong>Pedido entregado</strong>
              <p>Tu pedido #001 ha sido entregado exitosamente</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
