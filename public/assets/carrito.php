<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');

// Determinar si el usuario tiene descuento institucional
$descuento_institucion = 0;
if (isset($_SESSION['usuario_id'])) {
    $conn = new mysqli($host, $username, $password, $database);
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("SELECT correo, tipo_usuario_id FROM Usuarios WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['usuario_id']);
        $stmt->execute();
        $stmt->bind_result($correo, $tipo_usuario_id);
        if ($stmt->fetch()) {
            if (strpos($correo, '@utp.ac.pa') !== false && $tipo_usuario_id != 3) {
                $descuento_institucion = 0.15;
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<div class="profile-section" id="carrito-content">
  <div class="container" style="max-width:100vw;overflow-x:hidden;">
    <div class="profile-content" style="max-width:100vw;overflow-x:hidden;">
      <div class="profile-card">
        <div class="profile-avatar" style="display:flex;align-items:center;justify-content:center;width:120px;height:120px;border-radius:50%;border:5px solid #afa55f;margin:auto;font-size:4em;color:#afa55f;background:transparent;">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="profile-name">Carrito de Compras</div>
        <div class="profile-email">Tus productos seleccionados</div>
        <div class="profile-stats">
            <div class="stat-item">
              <div class="stat-number" id="total-productos">0</div>
              <div class="stat-label">Productos</div>
            </div>
            <div class="stat-item">
              <div class="stat-number" id="total-precio">$0.00</div>
              <div class="stat-label">Total</div>
            </div>
            <?php if ($descuento_institucion > 0): ?>
            <div class="stat-item">
              <div class="stat-number" id="descuento-label">-15%</div>
              <div class="stat-label">Descuento UTP</div>
            </div>
            <?php endif; ?>
        </div>
      </div>
      <div class="profile-details" style="max-width:100vw;overflow-x:hidden;">
        <div class="profile-tabs">
          <button class="tab-btn active" onclick="showTab('cart-items', event)">Productos</button>
          <button class="tab-btn" onclick="showTab('cart-summary', event)">Resumen</button>
        </div>
<script>
// Script para tabs de carrito
function showTab(tabId, event) {
  var tabs = document.querySelectorAll('.tab-content');
  tabs.forEach(function(tab) {
    tab.classList.remove('active');
  });
  var btns = document.querySelectorAll('.tab-btn');
  btns.forEach(function(btn) {
    btn.classList.remove('active');
  });
  document.getElementById(tabId).classList.add('active');
  event.target.classList.add('active');
}

// Cargar carrito al inicializar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarCarritoCompleto();
    
    // Usar el sistema de sincronización mejorado
    if (window.carritoSync) {
        window.carritoSync.agregarCallback(() => {
            cargarCarritoCompleto();
            // NO mostrar mensaje - solo actualizar silenciosamente
        });
    }
});

function cargarCarritoCompleto() {
    // Mostrar loading mientras carga
    const container = document.getElementById('carrito-productos-lista');
    if (container) {
        container.innerHTML = `
            <div class="cart-loading">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Cargando carrito...</p>
            </div>
        `;
    }
    
    fetch('./public/assets/carrito_api.php?action=obtener')
    .then(response => response.json())
    .then(data => {
        if (data.success && data.productos && data.productos.length > 0) {
            mostrarProductosCarrito(data.productos, data.total, data.cantidad_total);
            actualizarResumen(data.total);
        } else {
            // Si no hay productos o hay error, mostrar carrito vacío
            mostrarCarritoVacio();
        }
    })
    .catch(error => {
        console.error('Error al cargar carrito:', error);
        // En caso de error, mostrar carrito vacío
        mostrarCarritoVacio();
    });
}

function mostrarProductosCarrito(productos, total, cantidadTotal) {
    const container = document.getElementById('carrito-productos-lista');
    
    // Verificar que los datos sean válidos
    if (!productos || !Array.isArray(productos) || productos.length === 0) {
        mostrarCarritoVacio();
        return;
    }
    
    // Actualizar estadísticas del header CON LOS DATOS DEL CARRITO
    const totalProductosEl = document.getElementById('total-productos');
    const totalPrecioEl = document.getElementById('total-precio');
    
    if (totalProductosEl) totalProductosEl.textContent = cantidadTotal || '0';
    if (totalPrecioEl) totalPrecioEl.textContent = '$' + parseFloat(total || 0).toFixed(2);
    
    // Mostrar productos en el contenedor
    if (container) {
        container.innerHTML = productos.map(producto => `
            <div class="cart-item">
                <img src="./public/assets/${producto.imagen_url || 'placeholder.jpg'}" 
                     alt="${producto.nombre}" 
                     class="item-image">
                <div class="item-info">
                    <div class="item-name">${producto.nombre}</div>
                    <div class="item-price">$${parseFloat(producto.precio).toFixed(2)}</div>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="cambiarCantidadCompleta(${producto.carrito_producto_id}, ${producto.cantidad - 1})">-</button>
                        <input type="text" class="qty-input" value="${producto.cantidad}" readonly>
                        <button class="qty-btn" onclick="cambiarCantidadCompleta(${producto.carrito_producto_id}, ${producto.cantidad + 1})">+</button>
                    </div>
                </div>
                <button class="remove-btn" onclick="eliminarProductoCompleto(${producto.carrito_producto_id})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `).join('');
    }
}

function mostrarCarritoVacio() {
    const container = document.getElementById('carrito-productos-lista');
    
    // Actualizar interfaz de productos vacía
    if (container) {
        container.innerHTML = `
            <div class="cart-empty">
                <i class="fas fa-shopping-cart" style="font-size: 4em; color: #ddd; margin-bottom: 20px;"></i>
                <h3>Tu carrito está vacío</h3>
                <p>¡Agrega algunos productos para comenzar!</p>
                <a href="./index.php?content=productos" class="btn-back-shopping">
                    <i class="fas fa-arrow-left"></i> Continuar comprando
                </a>
            </div>
        `;
    }
    
    // Actualizar todas las estadísticas a 0 de forma consistente
    const elementos = {
        'total-productos': '0',
        'total-precio': '$0.00',
        'subtotal-original': '$0.00',
        'costo-envio': '$0.00',
        'descuento': '$0.00',
        'total-final': '$0.00'
    };
    
    // Aplicar todos los valores de una vez
    Object.entries(elementos).forEach(([id, valor]) => {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.textContent = valor;
        }
    });
}

function actualizarResumen(subtotal) {
    const envio = 0; // Puedes calcular el envío aquí
    let descuento = 0;
    let descuentoInstitucion = <?php echo $descuento_institucion; ?>;
    if (descuentoInstitucion > 0) {
        descuento = subtotal * descuentoInstitucion;
    }
    const total = subtotal + envio - descuento;
    // Mostrar el subtotal original
    if (document.getElementById('subtotal-original')) {
        document.getElementById('subtotal-original').textContent = '$' + subtotal.toFixed(2);
    }
    // Actualizar el resumen con los valores del carrito
    document.getElementById('costo-envio').textContent = '$' + envio.toFixed(2);
    document.getElementById('descuento').textContent = (descuento > 0 ? '-$' : '$') + descuento.toFixed(2);
    document.getElementById('total-final').textContent = '$' + total.toFixed(2);
    // También actualizar las estadísticas del header con el total final
    document.getElementById('total-precio').textContent = '$' + total.toFixed(2);
}

function cambiarCantidadCompleta(carritoProductoId, nuevaCantidad) {
    if (nuevaCantidad < 1) {
        eliminarProductoCompleto(carritoProductoId);
        return;
    }
    
    const data = {
        action: 'actualizar',
        carrito_producto_id: carritoProductoId,
        cantidad: nuevaCantidad
    };
    
    fetch('./public/assets/carrito_api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recargar todo el carrito para mantener consistencia en estadísticas y resumen
            cargarCarritoCompleto();
            
            // Mostrar "Carrito actualizado" al cambiar cantidad
            if (window.mensajeUnico) {
                window.mensajeUnico.mostrar('Carrito actualizado ✅');
            }
            
            // Notificar cambios usando el sistema mejorado
            if (window.carritoSync) {
                window.carritoSync.notificarCambio();
            }
        } else {
            if (window.mensajeUnico) {
                window.mensajeUnico.mostrar(data.message || 'Error al actualizar cantidad', 'error');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.mensajeUnico) {
            window.mensajeUnico.mostrar('Error de conexión', 'error');
        }
    });
}

function eliminarProductoCompleto(carritoProductoId) {
    if (!confirm('¿Estás seguro de que quieres eliminar este producto?')) {
        return;
    }
    
    const data = {
        action: 'eliminar',
        carrito_producto_id: carritoProductoId
    };
    
    fetch('./public/assets/carrito_api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recargar todo el carrito para actualizar estadísticas y resumen
            cargarCarritoCompleto();
            
            // Mostrar "Carrito actualizado" al eliminar producto
            if (window.mensajeUnico) {
                window.mensajeUnico.mostrar('Carrito actualizado ✅');
            }
            
            // Notificar cambios usando el sistema mejorado
            if (window.carritoSync) {
                window.carritoSync.notificarCambio();
            }
        } else {
            if (window.mensajeUnico) {
                window.mensajeUnico.mostrar(data.message || 'Error al eliminar producto', 'error');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.mensajeUnico) {
            window.mensajeUnico.mostrar('Error de conexión', 'error');
        }
    });
}
</script>
        <div id="cart-items" class="tab-content active">
          <div class="cart-items cart-center-align" id="carrito-productos-lista">
            <!-- Los productos del carrito se cargan aquí dinámicamente -->
            <div class="cart-loading">
              <i class="fas fa-spinner fa-spin"></i>
              <p>Cargando carrito...</p>
            </div>
          </div>
        </div>
        <div id="cart-summary" class="tab-content">
          <div class="cart-summary summary-bg cart-center-align">
            <div class="summary-table">
              <div class="summary-row">
                <div class="summary-label">Subtotal:</div>
                <div class="summary-value" id="subtotal-original">$0.00</div>
              </div>
              <div class="summary-row">
                <div class="summary-label">Envío:</div>
                <div class="summary-value" id="costo-envio">$0.00</div>
              </div>
              <div class="summary-row">
                <div class="summary-label">Descuento:</div>
                <div class="summary-value" id="descuento">$0.00</div>
              </div>
              <div class="summary-row summary-total-row">
                <div class="summary-label">Total:</div>
                <div class="summary-value" id="total-final">$0.00</div>
              </div>
            </div>
            <div class="payment-select-block">
              <div class="payment-label">Selecciona método de pago:</div>
              <div class="payment-icons-select">
                <input type="radio" id="pay-visa" name="payment-method" value="visa" checked>
                <label for="pay-visa"><i class="fab fa-cc-visa"></i></label>
                <input type="radio" id="pay-mastercard" name="payment-method" value="mastercard">
                <label for="pay-mastercard"><i class="fab fa-cc-mastercard"></i></label>
                <input type="radio" id="pay-paypal" name="payment-method" value="paypal">
                <label for="pay-paypal"><i class="fab fa-cc-paypal"></i></label>
                <input type="radio" id="pay-stripe" name="payment-method" value="stripe">
                <label for="pay-stripe"><i class="fab fa-cc-stripe"></i></label>
              </div>
            </div>
            <button class="checkout-btn" onclick="simularPago()">
              <i class="fas fa-credit-card"></i> <span>Proceder al Pago</span>
            </button>
<script>
function simularPago() {
    // Verificar si hay productos en el carrito antes de procesar
    const totalProductos = document.getElementById('total-productos').textContent;
    const totalPrecio = document.getElementById('total-final').textContent;
    
    if (totalProductos === '0' || totalPrecio === '$0.00') {
        // Mostrar mensaje de error si el carrito está vacío
        if (window.mensajeUnico) {
            window.mensajeUnico.mostrar('No hay productos en el carrito para procesar el pago', 'error');
        } else {
            alert('No hay productos en el carrito para procesar el pago');
        }
        return;
    }
    
    // Primero vaciar el carrito en el backend
    fetch('./public/assets/carrito_api.php?action=vaciar', { 
        method: 'POST' 
    })
    .then(response => response.json())
    .then(data => {
        // Actualizar interfaz solo después de confirmar que el backend se vació
        actualizarInterfazCarritoVacio();
        
        // Notificar cambios al carrito flotante
        if (window.carritoSync && typeof window.carritoSync.notificarCambio === 'function') {
            window.carritoSync.notificarCambio();
        }
        
        // Mostrar modal de éxito
        setTimeout(mostrarModalExito, 100);
    })
    .catch(error => {
        console.error('Error al vaciar carrito:', error);
        // Si hay error en el backend, forzar actualización de interfaz
        actualizarInterfazCarritoVacio();
        if (window.carritoSync && typeof window.carritoSync.notificarCambio === 'function') {
            window.carritoSync.notificarCambio();
        }
        setTimeout(mostrarModalExito, 100);
    });
}

// Función separada para actualizar la interfaz a estado vacío
function actualizarInterfazCarritoVacio() {
    // Actualizar lista de productos
    const container = document.getElementById('carrito-productos-lista');
    if (container) {
        container.innerHTML = `
            <div class="cart-empty">
                <i class="fas fa-shopping-cart" style="font-size: 4em; color: #ddd; margin-bottom: 20px;"></i>
                <h3>Tu carrito está vacío</h3>
                <p>¡Agrega algunos productos para comenzar!</p>
                <a href="./index.php?content=productos" class="btn-back-shopping">
                    <i class="fas fa-arrow-left"></i> Continuar comprando
                </a>
            </div>
        `;
    }
    
    // Actualizar estadísticas del header
    const totalProductosEl = document.getElementById('total-productos');
    const totalPrecioEl = document.getElementById('total-precio');
    if (totalProductosEl) totalProductosEl.textContent = '0';
    if (totalPrecioEl) totalPrecioEl.textContent = '$0.00';

    // Actualizar resumen de pago
    const subtotalEl = document.getElementById('subtotal-original');
    const envioEl = document.getElementById('costo-envio');
    const descuentoEl = document.getElementById('descuento');
    const totalFinalEl = document.getElementById('total-final');
    
    if (subtotalEl) subtotalEl.textContent = '$0.00';
    if (envioEl) envioEl.textContent = '$0.00';
    if (descuentoEl) descuentoEl.textContent = '$0.00';
    if (totalFinalEl) totalFinalEl.textContent = '$0.00';
}

// Modal centrado de éxito
function mostrarModalExito() {
    let modal = document.getElementById('modal-exito-pago');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'modal-exito-pago';
        modal.innerHTML = `
            <div class="modal-exito-bg"></div>
            <div class="modal-exito-content">
                <i class="fas fa-check-circle modal-exito-icon"></i>
                <h2>¡Compra realizada con éxito!</h2>
                <p>Tu pago fue procesado correctamente.<br>Gracias por tu compra.</p>
                <button class="modal-exito-btn" onclick="cerrarModalExito()">Cerrar</button>
            </div>
        `;
        document.body.appendChild(modal);
    }
    modal.style.display = 'flex';
    setTimeout(() => {
        document.querySelector('.modal-exito-btn').focus();
    }, 100);
}
function cerrarModalExito() {
    let modal = document.getElementById('modal-exito-pago');
    if (modal) {
        modal.style.display = 'none';
    }
}
</script>
          </div>
<style>
  .cart-center-align {
    margin-left: 0;
    margin-right: auto;
    width: 100%;
    max-width: 480px;
  }
    .summary-bg {
      background: linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);
      border-radius: 18px;
      box-shadow: 0 4px 18px rgba(123,91,132,0.10);
      padding: 36px 36px 32px 36px;
      margin-top: 18px;
      width: 100%;
      max-width: 480px;
      display: flex;
      flex-direction: column;
      gap: 28px;
    }
    .summary-table {
      width: 100%;
      margin-bottom: 8px;
    }
    .summary-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #e0e0e0;
    }
    .summary-row:last-child {
      border-bottom: 2px solid #afa55f;
    }
    .summary-label {
      font-weight: 600;
      color: #b3b3b3;
      font-size: 1.08em;
    }
    .summary-total-row .summary-label {
      color: #7b5b84;
      font-size: 1.15em;
    }
    .summary-value {
      color: #7b5b84;
      font-weight: 600;
      font-size: 1.08em;
    }
    .summary-total-row .summary-value {
      color: #afa55f;
      font-size: 1.15em;
    }
    .payment-select-block {
      margin: 0 0 8px 0;
    }
    .payment-label {
      font-weight: 600;
      color: #7b5b84;
      margin-bottom: 10px;
      display: block;
      font-size: 1.08em;
    }
    .payment-icons-select {
      display: flex;
      gap: 22px;
      align-items: center;
      font-size: 2.2em;
    }
    .payment-icons-select input[type="radio"] {
      display: none;
    }
    .payment-icons-select label {
      color: #7b5b84;
      cursor: pointer;
      transition: color 0.2s, transform 0.2s, box-shadow 0.2s;
      padding: 4px 8px;
      border-radius: 10px;
      background: transparent;
      display: flex;
      align-items: center;
    }
    .payment-icons-select input[type="radio"]:checked + label {
      color: #fff;
      background: #afa55f;
      transform: scale(1.12);
      box-shadow: 0 2px 12px rgba(175,165,95,0.13);
    }
    .checkout-btn {
      margin-top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-size: 1.18em;
      background: #7b5b84;
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 16px 0;
      width: 100%;
      cursor: pointer;
      transition: background 0.2s;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .checkout-btn:hover {
      background: #5a4463;
    }
    
    /* Estilos para carrito vacío */
    .cart-empty {
      text-align: center;
      padding: 40px 20px;
      color: #666;
    }
    
    .cart-empty h3 {
      color: #7b5b84;
      margin: 10px 0;
    }
    
    .btn-back-shopping {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #7b5b84;
      color: white;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 25px;
      margin-top: 20px;
      transition: background 0.3s ease;
      font-weight: 600;
    }
    
    .btn-back-shopping:hover {
      background: #5a4463;
      text-decoration: none;
      color: white;
    }
    
    /* Estilos para loading */
    .cart-loading {
      text-align: center;
      padding: 40px 20px;
      color: #7b5b84;
    }
    
    .cart-loading i {
      font-size: 2em;
      margin-bottom: 15px;
    }
    
    /* Estilos para mensajes toast */
    .toast-mensaje {
      position: fixed;
      top: 20px;
      right: 20px;
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      padding: 15px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
      z-index: 10000;
      transform: translateX(400px);
      transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      display: flex;
      align-items: center;
      gap: 10px;
      max-width: 300px;
    }
    
    .toast-mensaje.show {
      transform: translateX(0);
    }
    
    .toast-mensaje.error {
      background: linear-gradient(135deg, #dc3545, #c82333);
      box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
    
    .toast-close {
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 1.1em;
      margin-left: auto;
      padding: 0;
      opacity: 0.8;
    }
    
    .toast-close:hover {
      opacity: 1;
    }
  /* Modal de éxito de compra */
  #modal-exito-pago {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100vw; height: 100vh;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 99999;
  }
  .modal-exito-bg {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.35);
    z-index: 1;
  }
  .modal-exito-content {
    position: relative;
    z-index: 2;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(123,91,132,0.18);
    padding: 38px 32px 32px 32px;
    text-align: center;
    min-width: 320px;
    max-width: 90vw;
    animation: modalFadeIn 0.3s;
  }
  .modal-exito-icon {
    color: #28a745;
    font-size: 3.5em;
    margin-bottom: 18px;
  }
  .modal-exito-btn {
    margin-top: 24px;
    background: #7b5b84;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px 32px;
    font-size: 1.1em;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
  }
  .modal-exito-btn:hover {
    background: #5a4463;
  }
  @keyframes modalFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }
</style>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="./public/assets/js/carrito-sync.js"></script>
