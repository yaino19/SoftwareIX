<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');
?>
<div class="productos-section" style="padding:32px 0 0 0; background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%); min-height:60vh;">
  <div class="container">
    <h3 class="section-title" style="margin-top:0;">Todos los Productos</h3>
    <div class="productos-list" style="margin-top:32px;">
      <div class="producto-item" style="background:#fff; border-radius:16px; box-shadow:0 4px 18px rgba(123,91,132,0.10); margin-bottom:24px; padding:24px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
        <div style="color:#888;font-size:1.2em;">Próximamente catálogo completo...</div>
      </div>
      <!-- Aqui agrega los produtcos IAN -->
    </div>
  </div>
</div>
<style>
.productos-list { margin-top:32px; }
.producto-item:hover { box-shadow:0 8px 32px rgba(123,91,132,0.18); }
</style>