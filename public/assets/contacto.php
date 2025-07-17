<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');
?>
<?php
if (!isset($_SESSION['usuario_id'])) {
  // Visitante: contacto visual expandido y moderno
  echo '<div class="contact-section" style="padding:0;background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);min-height:80vh;width:100vw;display:flex;align-items:center;justify-content:center;">
    <div class="container" style="width:100vw;max-width:1600px;margin:0 auto;padding:0;">
      <div style="display:flex;flex-wrap:nowrap;gap:0;align-items:stretch;justify-content:center;width:100vw;">
        <div class="contact-card" style="flex:1 1 50%;min-width:320px;max-width:700px;background:white;padding:56px 48px 56px 48px;border-radius:0;border-right:none;box-shadow:0 12px 48px rgba(123,91,132,0.13);display:flex;flex-direction:column;align-items:center;">
          <img src="./public/assets/img/LogoPrincipal.png" alt="Logo Zona UTP" style="width:90px;height:90px;border-radius:50%;margin-bottom:18px;box-shadow:0 2px 12px #afa55f22;">
          <h2 style="color:#100418;font-size:1.45em;margin-bottom:10px;text-align:center;letter-spacing:0.5px;font-weight:600;">Contacto Zona UTP</h2>
          <p style="font-size:1em;color:#555;margin-bottom:18px;text-align:center;line-height:1.4;">¿Tienes dudas, sugerencias o necesitas ayuda?<br>Contáctanos por cualquiera de los siguientes medios.<br><span style="color:#7b5b84;font-weight:600;">¡Estamos para apoyarte!</span></p>
          <div class="contact-cards-row" style="width:100%;display:flex;flex-wrap:wrap;gap:32px;justify-content:center;align-items:stretch;margin-top:10px;">
            <a href="https://www.facebook.com/utpcrveraguas" target="_blank" class="contact-card-mini" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #3b599822;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s; text-decoration:none;">
              <i class="fab fa-facebook fa-2x" style="color:#3b5998;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#3b5998;">Facebook</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">utp.panama</span>
            </a>
            <a href="https://x.com/UTPVeraguas" target="_blank" class="contact-card-mini" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #1da1f222;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s; text-decoration:none;">
              <i class="fab fa-twitter fa-2x" style="color:#1da1f2;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#1da1f2;">Twitter</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">@utp_panama</span>
            </a>
            <a href="https://www.instagram.com/utpveraguas" target="_blank" class="contact-card-mini" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #e4405f22;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s; text-decoration:none;">
              <i class="fab fa-instagram fa-2x" style="color:#e4405f;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#e4405f;">Instagram</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">utp.panama</span>
            </a>
            <a href="https://www.tiktok.com/@utp.veraguas" target="_blank" class="contact-card-mini" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #00000022;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s; text-decoration:none;">
              <i class="fab fa-tiktok fa-2x" style="color:#000;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#000;">TikTok</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">@utp.veraguas</span>
            </a>
            <div class="contact-card-mini" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #e67e2222;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s;">
              <i class="fas fa-map-marker-alt fa-2x" style="color:#e67e22;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#e67e22;">Dirección</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">Campus UTP, Vía Centenario, Panamá</span>
            </div>
          </div>
        </div>
        <div class="contact-card" style="flex:1 1 50%;min-width:320px;max-width:700px;background:linear-gradient(135deg,#afa55f22 0%,#7b5b8422 100%);padding:56px 48px 56px 48px;border-radius:0;border-left:none;box-shadow:0 12px 48px rgba(123,91,132,0.13);display:flex;flex-direction:column;align-items:center;justify-content:center;">
          <i class="fas fa-users fa-3x" style="color:#7b5b84;margin-bottom:24px;"></i>
          <h3 style="color:#100418;font-size:1.7em;margin-bottom:16px;text-align:center;letter-spacing:1px;">¿Por qué Zona UTP?</h3>
          <p style="font-size:1.15em;color:#555;text-align:center;line-height:1.6;">Zona UTP es la tienda oficial para estudiantes, egresados y visitantes. Aquí encuentras productos exclusivos, atención personalizada y el orgullo de ser parte de la comunidad UTP.<br><br><span style="color:#afa55f;font-weight:600;">¡Conéctate y vive la experiencia!</span></p>
        </div>
      </div>
    </div>
    <style>
      @media (max-width: 900px) {
        .contact-section .container > div { flex-direction: column !important; gap: 24px !important; }
        .contact-card { min-width: 0 !important; max-width: 100vw !important; margin: 0 !important; padding:32px 8px !important; border-radius:0 !important; }
      }
    </style>
  </div>';
} else {
  // Usuario autenticado: mostrar contacto completo
  ?>
  <div class="profile-section" id="contacto-content" style="padding:0;background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);min-height:80vh;width:100vw;display:flex;align-items:center;justify-content:center;">
    <div class="container" style="width:100vw;max-width:1600px;margin:0 auto;padding:0;">
      <div class="profile-content" style="display:flex;flex-wrap:wrap;gap:48px;align-items:stretch;justify-content:center;width:100vw;">
        <div class="profile-card" style="flex:1 1 480px;min-width:320px;max-width:700px;background:white;padding:56px 48px;border-radius:32px;box-shadow:0 12px 48px rgba(123,91,132,0.13);display:flex;flex-direction:column;align-items:center;">
          <img src="https://via.placeholder.com/120x120" alt="Contacto" class="profile-avatar" style="width:140px;height:140px;border-radius:50%;margin-bottom:24px;box-shadow:0 2px 18px #afa55f33;">
          <div class="profile-name" style="font-size:2.4em;margin-bottom:16px;letter-spacing:1px;">Contacto ZonaUTP</div>
          <div class="profile-email" style="font-size:1.15em;margin-bottom:18px;">soporte.zonautp@gmail.com</div>
          <div class="profile-stats" style="width:100%;margin-bottom:18px;">
            <div class="stat-item" style="display:flex;align-items:center;gap:22px;margin-bottom:22px;padding:22px 0;border-bottom:1px solid #eee;">
              <div class="stat-number"><i class="fas fa-map-marker-alt fa-2x" style="color:#e67e22;"></i></div>
              <div class="stat-label">Campus UTP, Vía Centenario, Panamá</div>
            </div>
            <div class="stat-item" style="display:flex;align-items:center;gap:22px;margin-bottom:22px;padding:22px 0;border-bottom:1px solid #eee;">
              <div class="stat-number"><i class="fab fa-facebook fa-2x" style="color:#3b5998;"></i></div>
              <div class="stat-label" style="display:block;">
                <a href="https://facebook.com/utp" target="_blank" style="color:#afa55f;display:block;">facebook.com/utp</a>
              </div>
            </div>
            <div class="stat-item" style="display:flex;align-items:center;gap:22px;margin-bottom:0;padding:22px 0;">
              <div class="stat-number"><i class="fab fa-instagram fa-2x" style="color:#e4405f;"></i></div>
              <div class="stat-label" style="display:block;">
                <a href="https://instagram.com/utp" target="_blank" style="color:#afa55f;display:block;">@utp</a>
              </div>
            </div>
          </div>
        </div>
        <div class="profile-details" style="flex:1 1 480px;min-width:320px;max-width:700px;background:linear-gradient(135deg,#afa55f22 0%,#7b5b8422 100%);padding:56px 48px;border-radius:32px;box-shadow:0 12px 48px rgba(123,91,132,0.13);display:flex;flex-direction:column;align-items:center;justify-content:center;">
          <div class="profile-tabs" style="margin-bottom:24px;">
            <button class="tab-btn active" onclick="showTab('contact-form', event)">Formulario de Contacto</button>
          </div>
          <div id="contact-form" class="tab-content active" style="width:100%;">
            <form class="contact-form" id="contactForm" style="background:transparent;padding:0;box-shadow:none;">
              <h4 style="margin-bottom:24px;font-size:1.3em;"><i class="fas fa-paper-plane"></i> Envíanos un Mensaje</h4>
              <div class="contact-form-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                <div class="form-group" style="grid-column:1/2;">
                  <label for="nombre">Nombre</label>
                  <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group" style="grid-column:2/3;">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group" style="grid-column:1/2;">
                  <label for="asunto">Asunto</label>
                  <input type="text" id="asunto" name="asunto" required>
                </div>
                <div class="form-group" style="grid-column:2/3;">
                  <label for="mensaje">Mensaje</label>
                  <textarea id="mensaje" name="mensaje" rows="4" required style="min-height:90px;"></textarea>
                </div>
              </div>
              <button type="submit" class="submit-btn" style="margin-top:18px;">Enviar Mensaje</button>
              <div id="contact-success" style="display:none;color:#27ae60;margin-top:18px;font-weight:600;"><i class="fas fa-check-circle"></i> ¡Mensaje enviado correctamente!</div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <style>
      @media (max-width: 900px) {
        .contact-section .container > div { flex-direction: column !important; gap: 24px !important; }
        .contact-section .contact-card { min-width: 0 !important; max-width: 100vw !important; margin: 0 !important; padding:32px 8px !important; border-radius:0 !important; }
      }
    </style>
  </div>
  <?php
}
?>
    </div>
  </div>
</div>
</div>
