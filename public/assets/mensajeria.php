<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');
?>
<div class="mensajeria-section" style="padding:32px 0 0 0; background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%); min-height:60vh;">
  <div class="container">
    <h3 class="section-title" style="margin-top:0;">Feedback</h3>
    <div class="mensajes-list">
      <div class="mensaje-item" style="background:#fff; border-radius:16px; box-shadow:0 4px 18px rgba(123,91,132,0.10); margin-bottom:24px; padding:24px; display:flex; flex-direction:column;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <span style="font-weight:600; color:#7b5b84;">De:</span> 
          </div>
        </div>
        <div style="margin-top:16px; color:#222; font-size:1.08em;">
          <span style="font-weight:600; color:#afa55f;">Mensaje:</span>
        </div>
        <div style="margin-top:18px; display:flex; gap:16px;">
          <button class="btn-responder" style="background:#7b5b84; color:#fff; border:none; border-radius:8px; padding:8px 18px; cursor:pointer;">Responder</button>
          <button class="btn-leido" style="background:#afa55f; color:#fff; border:none; border-radius:8px; padding:8px 18px; cursor:pointer;">Leído</button>
          <button class="btn-eliminar" style="background:#e74c3c; color:#fff; border:none; border-radius:8px; padding:8px 18px; cursor:pointer;">Eliminar</button>
        </div>
      </div>
      
    </div>

  </div>
</div>
<style>
.mensajes-list { margin-top:32px; }
.mensaje-item:hover { box-shadow:0 8px 32px rgba(123,91,132,0.18); }
.btn-responder:hover { background:#5a4463; }
.btn-leido:hover { background:#d4c97a; color:#222; }
.btn-eliminar:hover { background:#c0392b; }
</style>
