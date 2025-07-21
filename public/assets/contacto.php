<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');
?>
<?php
if (!isset($_SESSION['usuario_id'])) {
  // Visitante: solo muestra un mensaje simple para evitar duplicidad y conflicto de estilos
  echo '<div class="contacto-visitante-msg" style="width:100%;padding:48px 0;text-align:center;background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);min-height:60vh;">
    <img src="./public/assets/img/LogoPrincipal.png" alt="Logo Zona UTP" style="width:80px;height:80px;border-radius:50%;margin-bottom:18px;box-shadow:0 2px 12px #afa55f22;">
    <h2 style="color:#100418;font-size:1.5em;margin-bottom:10px;letter-spacing:0.5px;font-weight:600;">Contacto Zona UTP</h2>
    <p style="font-size:1.1em;color:#555;margin-bottom:18px;">Para consultas, dudas o sugerencias, por favor utiliza el formulario de contacto disponible para usuarios registrados o síguenos en nuestras redes sociales.</p>
    <div style="margin:18px 0 0 0;">
      <a href="https://facebook.com/utp" target="_blank" style="margin:0 12px;color:#3b5998;font-size:2em;"><i class="fab fa-facebook"></i></a>
      <a href="https://instagram.com/utp" target="_blank" style="margin:0 12px;color:#e4405f;font-size:2em;"><i class="fab fa-instagram"></i></a>
      <a href="https://x.com/UTPVeraguas" target="_blank" style="margin:0 12px;color:#1da1f2;font-size:2em;"><i class="fab fa-twitter"></i></a>
      <a href="https://www.tiktok.com/@utp.veraguas" target="_blank" style="margin:0 12px;color:#000;font-size:2em;"><i class="fab fa-tiktok"></i></a>
    </div>
    <div style="margin-top:18px;color:#afa55f;font-weight:600;">soporte.zonautp@gmail.com</div>
  </div>';
} else {
  // Usuario autenticado: mostrar contacto completo
  ?>
  <div class="contacto-auth-wrapper" style="padding:60px 0;background:linear-gradient(135deg,#f4f7fc 0%,#e8f1ff 100%);min-height:80vh;width:100vw;">
    <div class="contacto-auth-container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
      <div class="contacto-auth-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:start;">
        
        <!-- Sección de Información y Redes Sociales -->
        <div class="contacto-info-panel" style="background:#ffffff;padding:40px;border-radius:20px;box-shadow:0 8px 32px rgba(0,0,0,0.08);border:1px solid #e3f2fd;">
          <div class="contacto-header" style="text-align:center;margin-bottom:30px;">
            <img src="./public/assets/img/LogoPrincipal.png" alt="Logo UTP" style="width:80px;height:80px;border-radius:50%;margin-bottom:15px;box-shadow:0 4px 16px rgba(74,144,226,0.2);">
            <h3 style="color:#2c3e50;font-size:1.8em;margin-bottom:8px;font-weight:600;">Contacto UTP</h3>
            <p style="color:#7f8c8d;font-size:1.1em;margin-bottom:20px;">soporte.zonautp@gmail.com</p>
          </div>
          
          <div class="contacto-location" style="background:#f8fafc;padding:20px;border-radius:12px;margin-bottom:25px;border-left:4px solid #4a90e2;">
            <div style="display:flex;align-items:center;gap:12px;">
              <i class="fas fa-map-marker-alt" style="color:#4a90e2;font-size:1.2em;"></i>
              <span style="color:#2c3e50;font-weight:500;">Campus UTP, Vía Centenario, Panamá</span>
            </div>
          </div>
          
          <div class="contacto-social-section">
            <h4 style="color:#2c3e50;font-size:1.2em;margin-bottom:20px;font-weight:600;">Síguenos en redes sociales</h4>
            <div class="contacto-social-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
              <a href="https://facebook.com/utp" target="_blank" class="contacto-social-item" style="display:flex;align-items:center;gap:10px;padding:12px 15px;background:#f8fafc;border-radius:10px;text-decoration:none;border:1px solid #e3f2fd;transition:all 0.3s ease;">
                <i class="fab fa-facebook" style="color:#3b5998;font-size:1.3em;"></i>
                <span style="color:#2c3e50;font-size:0.9em;font-weight:500;">Facebook</span>
              </a>
              <a href="https://instagram.com/utp" target="_blank" class="contacto-social-item" style="display:flex;align-items:center;gap:10px;padding:12px 15px;background:#f8fafc;border-radius:10px;text-decoration:none;border:1px solid #e3f2fd;transition:all 0.3s ease;">
                <i class="fab fa-instagram" style="color:#e4405f;font-size:1.3em;"></i>
                <span style="color:#2c3e50;font-size:0.9em;font-weight:500;">Instagram</span>
              </a>
              <a href="https://x.com/UTPVeraguas" target="_blank" class="contacto-social-item" style="display:flex;align-items:center;gap:10px;padding:12px 15px;background:#f8fafc;border-radius:10px;text-decoration:none;border:1px solid #e3f2fd;transition:all 0.3s ease;">
                <i class="fab fa-twitter" style="color:#1da1f2;font-size:1.3em;"></i>
                <span style="color:#2c3e50;font-size:0.9em;font-weight:500;">Twitter</span>
              </a>
              <a href="https://www.tiktok.com/@utp.veraguas" target="_blank" class="contacto-social-item" style="display:flex;align-items:center;gap:10px;padding:12px 15px;background:#f8fafc;border-radius:10px;text-decoration:none;border:1px solid #e3f2fd;transition:all 0.3s ease;">
                <i class="fab fa-tiktok" style="color:#000000;font-size:1.3em;"></i>
                <span style="color:#2c3e50;font-size:0.9em;font-weight:500;">TikTok</span>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Sección de Formulario -->
        <div class="contacto-form-panel" style="background:#ffffff;padding:40px;border-radius:20px;box-shadow:0 8px 32px rgba(0,0,0,0.08);border:1px solid #e3f2fd;">
          <h3 style="color:#2c3e50;font-size:1.8em;margin-bottom:25px;font-weight:600;text-align:center;">
            <i class="fas fa-paper-plane" style="color:#4a90e2;margin-right:10px;"></i>
            Envíanos un Mensaje
          </h3>
          
          <form class="contacto-form" id="contactForm">
            <div class="contacto-form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
              <div class="contacto-form-group">
                <label for="nombre" style="display:block;margin-bottom:8px;color:#2c3e50;font-weight:500;font-size:0.95em;">Nombre</label>
                <input type="text" id="nombre" name="nombre" required style="width:100%;padding:12px 15px;border:2px solid #e3f2fd;border-radius:8px;font-size:1em;color:#2c3e50;background:#ffffff;transition:border-color 0.3s ease;box-sizing:border-box;">
              </div>
              <div class="contacto-form-group">
                <label for="email" style="display:block;margin-bottom:8px;color:#2c3e50;font-weight:500;font-size:0.95em;">Email</label>
                <input type="email" id="email" name="email" required style="width:100%;padding:12px 15px;border:2px solid #e3f2fd;border-radius:8px;font-size:1em;color:#2c3e50;background:#ffffff;transition:border-color 0.3s ease;box-sizing:border-box;">
              </div>
            </div>
            
            <div class="contacto-form-group" style="margin-bottom:20px;">
              <label for="asunto" style="display:block;margin-bottom:8px;color:#2c3e50;font-weight:500;font-size:0.95em;">Asunto</label>
              <input type="text" id="asunto" name="asunto" required style="width:100%;padding:12px 15px;border:2px solid #e3f2fd;border-radius:8px;font-size:1em;color:#2c3e50;background:#ffffff;transition:border-color 0.3s ease;box-sizing:border-box;">
            </div>
            
            <div class="contacto-form-group" style="margin-bottom:25px;">
              <label for="mensaje" style="display:block;margin-bottom:8px;color:#2c3e50;font-weight:500;font-size:0.95em;">Mensaje</label>
              <textarea id="mensaje" name="mensaje" rows="5" required style="width:100%;padding:12px 15px;border:2px solid #e3f2fd;border-radius:8px;font-size:1em;color:#2c3e50;background:#ffffff;transition:border-color 0.3s ease;resize:vertical;min-height:120px;box-sizing:border-box;"></textarea>
            </div>
            
            <button type="submit" class="contacto-submit-btn" style="width:100%;padding:15px;background:linear-gradient(135deg,#4a90e2 0%,#357abd 100%);color:#ffffff;border:none;border-radius:10px;font-size:1.1em;font-weight:600;cursor:pointer;transition:all 0.3s ease;box-shadow:0 4px 16px rgba(74,144,226,0.3);">
              <i class="fas fa-paper-plane" style="margin-right:8px;"></i>
              Enviar Mensaje
            </button>
            
            <div id="contact-success" style="display:none;color:#27ae60;margin-top:15px;font-weight:600;text-align:center;padding:10px;background:#d4edda;border-radius:8px;border:1px solid #c3e6cb;">
              <i class="fas fa-check-circle"></i> ¡Mensaje enviado correctamente!
            </div>
          </form>
        </div>
        
      </div>
    </div>
    
    <style>
      .contacto-social-item:hover {
        background: #e3f2fd !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }
      
      .contacto-form input:focus,
      .contacto-form textarea:focus {
        outline: none;
        border-color: #4a90e2 !important;
        box-shadow: 0 0 0 3px rgba(74,144,226,0.1);
      }
      
      .contacto-submit-btn:hover {
        background: linear-gradient(135deg,#357abd 0%,#2968a3 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74,144,226,0.4);
      }
      
      @media (max-width: 768px) {
        .contacto-auth-grid {
          grid-template-columns: 1fr !important;
          gap: 25px !important;
        }
        .contacto-info-panel,
        .contacto-form-panel {
          padding: 25px !important;
        }
        .contacto-form-row {
          grid-template-columns: 1fr !important;
        }
        .contacto-social-grid {
          grid-template-columns: 1fr !important;
        }
      }
    </style>
  </div>
  <?php
}
?>
