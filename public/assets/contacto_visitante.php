<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');
// Contacto solo para visitantes
if (!isset($_SESSION['usuario_id'])) {
  echo '<div class="contact-section-visit" style="padding:0;background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);min-height:80vh;width:100vw;display:flex;align-items:center;justify-content:center;">
    <div class="container-visit" style="width:100vw;max-width:1600px;margin:0 auto;padding:0;">
      <div style="display:flex;flex-wrap:nowrap;gap:0;align-items:stretch;justify-content:center;width:100vw;">
        <div class="contact-card-visit" style="flex:1 1 50%;min-width:320px;max-width:700px;background:white;padding:56px 48px 56px 48px;border-radius:0;border-right:none;box-shadow:0 12px 48px rgba(123,91,132,0.13);display:flex;flex-direction:column;align-items:center;">
          <img src="./public/assets/img/LogoPrincipal.png" alt="Logo Zona UTP" style="width:90px;height:90px;border-radius:50%;margin-bottom:18px;box-shadow:0 2px 12px #afa55f22;">
          <h2 style="color:#100418;font-size:1.45em;margin-bottom:10px;text-align:center;letter-spacing:0.5px;font-weight:600;">Contacto Zona UTP</h2>
          <p style="font-size:1em;color:#555;margin-bottom:18px;text-align:center;line-height:1.4;">¿Tienes dudas, sugerencias o necesitas ayuda?<br>Contáctanos por cualquiera de los siguientes medios.<br><span style="color:#7b5b84;font-weight:600;">¡Estamos para apoyarte!</span></p>
          <div class="contact-cards-row-visit" style="width:100%;display:flex;flex-wrap:wrap;gap:32px;justify-content:center;align-items:stretch;margin-top:10px;">
            <a href="https://www.facebook.com/utpcrveraguas" target="_blank" class="contact-card-mini-visit" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #3b599822;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s; text-decoration:none;">
              <i class="fab fa-facebook fa-2x" style="color:#3b5998;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#3b5998;">Facebook</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">utp.panama</span>
            </a>
            <a href="https://x.com/UTPVeraguas" target="_blank" class="contact-card-mini-visit" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #1da1f222;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s; text-decoration:none;">
              <i class="fab fa-twitter fa-2x" style="color:#1da1f2;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#1da1f2;">Twitter</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">@utp_panama</span>
            </a>
            <a href="https://www.instagram.com/utpveraguas" target="_blank" class="contact-card-mini-visit" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #e4405f22;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s; text-decoration:none;">
              <i class="fab fa-instagram fa-2x" style="color:#e4405f;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#e4405f;">Instagram</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">utp.panama</span>
            </a>
            <a href="https://www.tiktok.com/@utp.veraguas" target="_blank" class="contact-card-mini-visit" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #00000022;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s; text-decoration:none;">
              <i class="fab fa-tiktok fa-2x" style="color:#000;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#000;">TikTok</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">@utp.veraguas</span>
            </a>
            <div class="contact-card-mini-visit" style="flex:1 1 180px;min-width:160px;max-width:220px;background:#f8f9fa;padding:20px 0 12px 0;border-radius:18px;box-shadow:0 2px 12px #e67e2222;display:flex;flex-direction:column;align-items:center;transition:box-shadow .2s;">
              <i class="fas fa-map-marker-alt fa-2x" style="color:#e67e22;margin-bottom:8px;"></i>
              <div style="font-size:1em;font-weight:500;color:#e67e22;">Dirección</div>
              <span style="font-size:0.9em;color:#555;margin-top:4px;">Campus UTP, Vía Centenario, Panamá</span>
            </div>
          </div>
        </div>
        <div class="contact-card-visit" style="flex:1 1 50%;min-width:320px;max-width:700px;background:linear-gradient(135deg,#afa55f22 0%,#7b5b8422 100%);padding:56px 48px 56px 48px;border-radius:0;border-left:none;box-shadow:0 12px 48px rgba(123,91,132,0.13);display:flex;flex-direction:column;align-items:center;justify-content:center;">
          <i class="fas fa-users fa-3x" style="color:#7b5b84;margin-bottom:24px;"></i>
          <h3 style="color:#100418;font-size:1.7em;margin-bottom:16px;text-align:center;letter-spacing:1px;">¿Por qué Zona UTP?</h3>
          <p style="font-size:1.15em;color:#555;text-align:center;line-height:1.6;">Zona UTP es la tienda oficial para estudiantes, egresados y visitantes. Aquí encuentras productos exclusivos, atención personalizada y el orgullo de ser parte de la comunidad UTP.<br><br><span style="color:#afa55f;font-weight:600;">¡Conéctate y vive la experiencia!</span></p>
        </div>
      </div>
    </div>
    <style>
      @media (max-width: 900px) {
        .contact-section-visit .container-visit > div { flex-direction: column !important; gap: 24px !important; }
        .contact-section-visit .contact-card-visit { min-width: 0 !important; max-width: 100vw !important; margin: 0 !important; padding:32px 8px !important; border-radius:0 !important; }
      }
    </style>
  </div>';
}
