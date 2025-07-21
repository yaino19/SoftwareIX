<?php
if (!isset($_SESSION)) session_start();
require_once(__DIR__ . '/../../config/config.php');
?>
<div class="profile-section" id="carrito-content">
  <div class="container" style="max-width:100vw;overflow-x:hidden;">
    <div class="profile-content" style="max-width:100vw;overflow-x:hidden;">
      <div class="profile-card">
        <img src="https://via.placeholder.com/120x120" alt="Carrito" class="profile-avatar">
        <div class="profile-name">Carrito de Compras</div>
        <div class="profile-email">Tus productos seleccionados</div>
        <div class="profile-stats">
          <div class="stat-item">
            <div class="stat-number"></div>
            <div class="stat-label">Productos</div>
          </div>
          <div class="stat-item">
            <div class="stat-number"></div>
            <div class="stat-label">Total</div>
          </div>
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
</script>
        <div id="cart-items" class="tab-content active">
          <div class="cart-items cart-center-align">
            <div class="cart-item">
              <img src="https://via.placeholder.com/80x80/7b5b84/fff?text=Ficticio" alt="Producto Ficticio" class="item-image">
              <div class="item-info">
                <div class="item-name">Camiseta Zona-UTP</div>
                <div class="item-price">$15.00</div>
                <div class="quantity-controls">
                  <button class="qty-btn" onclick="changeQuantity(this, -1)">-</button>
                  <input type="text" class="qty-input" value="1" readonly>
                  <button class="qty-btn" onclick="changeQuantity(this, 1)">+</button>
                </div>
              </div>
              <button class="remove-btn" onclick="removeItem(this)"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>
        <div id="cart-summary" class="tab-content">
          <div class="cart-summary summary-bg cart-center-align">
            <div class="summary-table">
              <div class="summary-row">
                <div class="summary-label">Envío:</div>
                <div class="summary-value"></div>
              </div>
              <div class="summary-row">
                <div class="summary-label">Descuento:</div>
                <div class="summary-value"></div>
              </div>
              <div class="summary-row summary-total-row">
                <div class="summary-label">Total:</div>
                <div class="summary-value"></div>
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
            <button class="checkout-btn">
              <i class="fas fa-credit-card"></i> <span>Proceder al Pago</span>
            </button>
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
</style>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
