<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');
?>
<div class="mensajeria-section" style="padding:32px 0 60px 0; background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%); min-height:calc(100vh - 200px);">
  <div class="container" style="max-width:1200px;">
    <h3 class="section-title" style="margin-top:0;">
      <i class="fas fa-inbox" style="margin-right:10px;color:#7b5b84;"></i>
      Bandeja de Mensajes
    </h3>
    
    <div id="mensajes-loading" style="text-align:center;padding:40px;">
      <i class="fas fa-spinner fa-spin" style="font-size:2em;color:#7b5b84;"></i>
      <p style="margin-top:10px;color:#666;">Cargando mensajes...</p>
    </div>
    
    <div id="mensajes-container" class="mensajes-list" style="display:none;">
      <!-- Los mensajes se cargarán aquí dinámicamente -->
    </div>
    
    <div id="no-mensajes" style="display:none;text-align:center;padding:60px 40px;background:#fff;border-radius:20px;box-shadow:0 6px 24px rgba(123,91,132,0.10);margin-bottom:60px;">
      <i class="fas fa-inbox" style="font-size:4em;color:#ddd;margin-bottom:20px;"></i>
      <h4 style="color:#666;margin-bottom:15px;font-size:1.3em;">No hay mensajes</h4>
      <p style="color:#999;font-size:1.1em;">Cuando los usuarios envíen mensajes, aparecerán aquí.</p>
    </div>
  </div>
</div>

<style>
.mensajeria-section {
  margin-bottom: 80px !important;
}
.mensajes-list { 
  margin-top:32px; 
  margin-bottom: 60px;
  padding-bottom: 40px;
}
.mensaje-item { 
  background:#fff; 
  border-radius:16px; 
  box-shadow:0 4px 18px rgba(123,91,132,0.10); 
  margin-bottom:20px; 
  overflow:hidden;
  border-left:4px solid #7b5b84;
  transition:all 0.3s ease, opacity 0.3s ease, transform 0.3s ease;
}
.mensaje-item.no-leido {
  border-left-color:#afa55f;
  background:#fffef7;
  box-shadow:0 6px 24px rgba(175,165,95,0.15);
}
.mensaje-item:hover { 
  box-shadow:0 8px 32px rgba(123,91,132,0.18); 
  transform: translateY(-2px);
}

.mensaje-preview {
  padding:24px;
  cursor:pointer;
  display:flex;
  justify-content:space-between;
  align-items:center;
}
.mensaje-preview:hover { background:rgba(123,91,132,0.03); }

.mensaje-header-compact {
  display:flex;
  justify-content:space-between;
  align-items:center;
  flex:1;
}
.mensaje-info-compact {
  display:flex;
  flex-direction:column;
  gap:5px;
  flex:1;
}
.mensaje-usuario-compact {
  font-weight:600;
  color:#7b5b84;
  font-size:1.1em;
  display:flex;
  align-items:center;
}
.mensaje-asunto-compact {
  color:#333;
  font-size:1em;
  font-weight:500;
  margin-top:3px;
}
.mensaje-fecha-compact {
  color:#999;
  font-size:0.85em;
  margin-left:20px;
}
.mensaje-expand-icon {
  color:#7b5b84;
  margin-left:15px;
  transition:transform 0.3s ease;
}

.mensaje-detalle {
  padding:0 24px 24px 24px;
  border-top:1px solid #f0f0f0;
  background:#fafafa;
}
.mensaje-email-detalle {
  color:#666;
  font-size:0.9em;
  margin-bottom:15px;
  padding-top:15px;
}

.mensaje-header {
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:15px;
}
.mensaje-info {
  display:flex;
  flex-direction:column;
  gap:5px;
}
.mensaje-usuario {
  font-weight:600;
  color:#7b5b84;
  font-size:1.1em;
}
.mensaje-email {
  color:#666;
  font-size:0.9em;
}
.mensaje-fecha {
  color:#999;
  font-size:0.85em;
}
.mensaje-asunto {
  font-weight:600;
  color:#333;
  font-size:1.1em;
  margin-bottom:10px;
}
.mensaje-contenido {
  color:#555;
  line-height:1.6;
  margin-bottom:20px;
  background:#fff;
  padding:15px;
  border-radius:8px;
  border:1px solid #e9ecef;
}
.mensaje-acciones {
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}
.btn-accion {
  border:none;
  border-radius:8px;
  padding:8px 16px;
  cursor:pointer;
  font-size:0.9em;
  transition:all 0.3s ease;
  display:flex;
  align-items:center;
  gap:5px;
}
.btn-leido { background:#28a745; color:#fff; }
.btn-leido:hover { background:#218838; }
.btn-leido:disabled, .btn-leido[style*="cursor: default"] { 
  background:#6c757d !important; 
  cursor:default !important; 
}
.btn-eliminar { background:#dc3545; color:#fff; }
.btn-eliminar:hover { background:#c82333; }
.badge-nuevo {
  background:#afa55f;
  color:#fff;
  padding:3px 8px;
  border-radius:12px;
  font-size:0.75em;
  font-weight:600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    cargarMensajes();
});

function cargarMensajes() {
    fetch('./public/assets/mensajeria_api.php')
        .then(response => response.json())
        .then(data => {
            const loading = document.getElementById('mensajes-loading');
            const container = document.getElementById('mensajes-container');
            const noMensajes = document.getElementById('no-mensajes');
            
            loading.style.display = 'none';
            
            if (data.success && data.mensajes.length > 0) {
                container.innerHTML = '';
                data.mensajes.forEach(mensaje => {
                    container.appendChild(crearMensajeElement(mensaje));
                });
                container.style.display = 'block';
                noMensajes.style.display = 'none';
            } else {
                container.style.display = 'none';
                noMensajes.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('mensajes-loading').innerHTML = 
                '<p style="color:#dc3545;">Error al cargar mensajes</p>';
        });
}

function crearMensajeElement(mensaje) {
    const div = document.createElement('div');
    div.className = `mensaje-item ${!mensaje.leido ? 'no-leido' : ''}`;
    div.dataset.mensajeId = mensaje.id;
    
    const fecha = new Date(mensaje.fecha_envio).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    div.innerHTML = `
        <div class="mensaje-preview" onclick="toggleMensaje(${mensaje.id})">
            <div class="mensaje-header-compact">
                <div class="mensaje-info-compact">
                    <div class="mensaje-usuario-compact">
                        <i class="fas fa-user-circle" style="margin-right:8px;color:#7b5b84;"></i>
                        ${mensaje.usuario_nombre}
                        ${!mensaje.leido ? '<span class="badge-nuevo">NUEVO</span>' : ''}
                    </div>
                    <div class="mensaje-asunto-compact">${mensaje.asunto}</div>
                </div>
                <div class="mensaje-fecha-compact">${fecha}</div>
            </div>
            <div class="mensaje-expand-icon">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
        <div class="mensaje-detalle" id="detalle-${mensaje.id}" style="display:none;">
            <div class="mensaje-email-detalle">
                <i class="fas fa-envelope" style="margin-right:5px;color:#666;"></i>
                ${mensaje.usuario_email}
            </div>
            <div style="margin-bottom:8px;margin-top:15px;">
                <strong style="color:#7b5b84;">Mensaje:</strong>
            </div>
            <div class="mensaje-contenido">${mensaje.mensaje}</div>
            <div class="mensaje-acciones">
                ${!mensaje.leido ? `
                    <button class="btn-accion btn-leido" onclick="marcarLeido(${mensaje.id})">
                        <i class="fas fa-check"></i> Marcar como leído
                    </button>
                ` : ''}
                <button class="btn-accion btn-eliminar" onclick="eliminarMensaje(${mensaje.id})">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    `;
    
    return div;
}

// Función para expandir/contraer mensajes
function toggleMensaje(mensajeId) {
    const detalle = document.getElementById(`detalle-${mensajeId}`);
    const icon = document.querySelector(`[data-mensaje-id="${mensajeId}"] .mensaje-expand-icon i`);
    
    if (detalle.style.display === 'none') {
        // Cerrar otros mensajes abiertos
        document.querySelectorAll('.mensaje-detalle').forEach(det => {
            det.style.display = 'none';
        });
        document.querySelectorAll('.mensaje-expand-icon i').forEach(ic => {
            ic.className = 'fas fa-chevron-down';
        });
        
        // Abrir este mensaje
        detalle.style.display = 'block';
        icon.className = 'fas fa-chevron-up';
    } else {
        // Cerrar este mensaje
        detalle.style.display = 'none';
        icon.className = 'fas fa-chevron-down';
    }
}

// Función para marcar mensaje como leído
function marcarLeido(mensajeId) {
    if (confirm('¿Marcar este mensaje como leído?')) {
        fetch('./public/assets/mensaje_acciones_api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                accion: 'marcar_leido',
                mensaje_id: mensajeId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la interfaz
                const mensajeItem = document.querySelector(`[data-mensaje-id="${mensajeId}"]`);
                const badgeNuevo = mensajeItem.querySelector('.badge-nuevo');
                const btnLeido = mensajeItem.querySelector('.btn-leido');
                
                // Remover badge "NUEVO"
                if (badgeNuevo) {
                    badgeNuevo.remove();
                }
                
                // Cambiar el botón de "Marcar como leído" a "Leído"
                if (btnLeido) {
                    btnLeido.innerHTML = '<i class="fas fa-check-circle"></i> Leído';
                    btnLeido.style.background = '#6c757d';
                    btnLeido.style.cursor = 'default';
                    btnLeido.onclick = null; // Quitar la funcionalidad de click
                }
                
                // Cambiar estilo del mensaje (quitar clase no-leido)
                mensajeItem.classList.remove('no-leido');
                
                // Actualizar el badge de mensajería en el menú principal
                if (typeof window.actualizarBadgeMensajeria === 'function') {
                    window.actualizarBadgeMensajeria();
                }
                
                alert('Mensaje marcado como leído');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al marcar el mensaje como leído');
        });
    }
}

// Función para eliminar mensaje
function eliminarMensaje(mensajeId) {
    if (confirm('¿Estás seguro de que quieres eliminar este mensaje? Esta acción no se puede deshacer.')) {
        fetch('./public/assets/mensaje_acciones_api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                accion: 'eliminar',
                mensaje_id: mensajeId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remover el mensaje de la interfaz
                const mensajeItem = document.querySelector(`[data-mensaje-id="${mensajeId}"]`);
                if (mensajeItem) {
                    mensajeItem.style.opacity = '0';
                    mensajeItem.style.transform = 'translateX(-100%)';
                    setTimeout(() => {
                        mensajeItem.remove();
                        
                        // Verificar si quedan mensajes
                        const mensajesRestantes = document.querySelectorAll('.mensaje-item');
                        if (mensajesRestantes.length === 0) {
                            document.getElementById('mensajes-container').style.display = 'none';
                            document.getElementById('no-mensajes').style.display = 'block';
                        }
                        
                        // Actualizar el badge de mensajería
                        if (typeof window.actualizarBadgeMensajeria === 'function') {
                            window.actualizarBadgeMensajeria();
                        }
                    }, 300);
                }
                alert('Mensaje eliminado');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el mensaje');
        });
    }
}
</script>
