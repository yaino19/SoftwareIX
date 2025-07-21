<?php
if (!isset($_SESSION)) session_start();  

require_once(__DIR__ . '/config/config.php');

$filtro_nombre = null;
if (isset($_SESSION['usuario_id'])) {
    $conn = new mysqli($host, $username, $password, $database);
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("SELECT nombre FROM Usuarios WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['usuario_id']);
        $stmt->execute();
        $stmt->bind_result($nombre);
        if ($stmt->fetch()) {
            $filtro_nombre = $nombre;
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZonaUTP - Pagina Principal</title>
    <link rel="stylesheet" href="./public/assets/css/style-clothes.css" />
    <link rel="stylesheet" href="./public/assets/css/style.css" />
    <script src="./public/assets/js/main.js" defer></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="icon" href="./public/assets/img/LogoPrincipal.png" type="image/png" />
    <style>
      html {
        box-sizing: border-box;
      }
      *, *:before, *:after {
        box-sizing: inherit;
      }
      body {
        overflow-x: hidden;
      }
      body {
        font-family: 'Inter', Arial, Helvetica, sans-serif;
        background:rgb(255, 255, 255);
        color: #333;
      }
      .spa-section { display: none; }
      .spa-section.active { display: block; }
      main { min-height: 60vh; position: relative; z-index: 1; }
      .footer { width: 100%; background: #f8f9fa; color: #222; text-align: center; padding: 32px 0 18px 0; margin-top: 32px; position: relative; z-index: 2; }
      .footer-text { margin: 0 0 8px 0; font-size: 1em; }
      .modal-center {
        position: fixed;
        z-index: 9999;
        left: 0; top: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.18);
        display: none;
        align-items: center;
        justify-content: center;
        transition: opacity 0.2s;
      }
      .modal-center.show {
        display: flex;
      }
      .modal-content-center {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        padding: 32px 28px 24px 28px;
        min-width: 320px;
        max-width: 90vw;
        text-align: center;
        position: relative;
        animation: fadeInModal 0.2s;
      }
      .modal-close-center {
        position: absolute;
        top: 10px; right: 14px;
        background: none;
        border: none;
        font-size: 1.5em;
        color: #888;
        cursor: pointer;
        transition: color 0.2s;
      }
      .modal-close-center:hover {
        color: #e74c3c;
      }
      .modal-message-center p {
        margin: 0;
        color: #222;
        font-size: 1.08em;
        font-weight: 500;
        line-height: 1.5;
      }
      .banner-imgs {
        display: flex;
        gap: 24px;
        justify-content: center;
        align-items: center;
        margin-top: 24px;
        flex-wrap: wrap;
      }
      .banner-imgs img {
        max-width: 180px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        background: #fff;
        padding: 8px;
        transition: transform 0.2s;
      }
      .banner-imgs img:hover {
        transform: scale(1.05);
      }
      /* Contact, Cart, Profile sections enhanced styles */
      .contact-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      }
      .contact-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
      }
      .contact-info {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      }
      .contact-info h4 {
        color: #100418;
        font-size: 1.8em;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
      }
      .contact-item {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
      }
      .contact-item:hover {
        background: #e9ecef;
        transform: translateY(-2px);
      }
      .contact-item i {
        font-size: 1.5em;
        color: #7b5b84;
        width: 30px;
      }
      .contact-form {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      }
      .form-group {
        margin-bottom: 25px;
      }
      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #100418;
      }
      .form-group input,
      .form-group textarea {
        width: 100%;
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 1em;
        transition: border-color 0.3s ease;
      }
      .form-group input:focus,
      .form-group textarea:focus {
        outline: none;
        border-color: #7b5b84;
      }
      .submit-btn {
        background: linear-gradient(135deg, #7b5b84, #afa55f);
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 50px;
        font-size: 1.1em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
      }
      .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(123, 91, 132, 0.3);
      }
      .cart-section {
        padding: 60px 0;
        background: white;
      }
      .cart-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
      }
      .cart-items {
        background: transparent !important;
        padding: 30px;
        border-radius: 20px;
      }
      .cart-item {
        display: flex;
        align-items: center;
        gap: 20px;
        background: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
      }
      .cart-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
      }
      .item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
      }
      .item-info {
        flex: 1;
      }
      .item-name {
        font-size: 1.2em;
        font-weight: 600;
        color: #100418;
        margin-bottom: 5px;
      }
      .item-price {
        color: #7b5b84;
        font-size: 1.1em;
        font-weight: 600;
      }
      .quantity-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 10px 0;
      }
      .qty-btn {
        background: #7b5b84;
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2em;
        transition: all 0.2s ease;
      }
      .qty-btn:hover {
        background: #5a4463;
      }
      .qty-input {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 5px;
      }
      .remove-btn {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
      }
      .remove-btn:hover {
        background: #c0392b;
      }
      .cart-summary {
        background: #100418;
        color: white;
        padding: 30px;
        border-radius: 20px;
        height: fit-content;
      }
      .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #333;
      }
      .summary-total {
        font-size: 1.3em;
        font-weight: 700;
        border-bottom: 2px solid #7b5b84;
      }
      .checkout-btn {
        background: linear-gradient(135deg, #afa55f, #7b5b84);
        color: white;
        padding: 15px;
        border: none;
        border-radius: 50px;
        font-size: 1.2em;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
        transition: all 0.3s ease;
      }
      .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(175, 165, 95, 0.3);
      }
      .profile-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #100418 0%, #2c1e30 100%);
        color: white;
      }
      .profile-content {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 40px;
      }
      .profile-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.2);
        box-sizing: border-box;
        width: 100%;
        max-width: 100vw;
      }
      .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin-bottom: 20px;
        border: 4px solid #afa55f;
      }
      .profile-name {
        font-size: 1.8em;
        font-weight: 700;
        margin-bottom: 10px;
      }
      .profile-email {
        color: #afa55f;
        font-size: 1.1em;
        margin-bottom: 20px;
      }
      .profile-stats {
        display: flex;
        justify-content: space-around;
        margin-top: 30px;
      }
      .stat-item {
        text-align: center;
      }
      .stat-number {
        font-size: 2em;
        font-weight: 700;
        color: #afa55f;
      }
      .stat-label {
        font-size: 0.9em;
        opacity: 0.8;
      }
      .profile-details {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.2);
      }
      .profile-tabs {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
      }
      .tab-btn {
        background: transparent;
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
        padding: 10px 20px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
      }
      .tab-btn.active {
        background: #afa55f;
        border-color: #afa55f;
      }
      .tab-content {
        display: none;
      }
      .tab-content.active {
        display: block;
      }
      .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
      }
      .info-item {
        background: rgba(255,255,255,0.05);
        padding: 20px;
        border-radius: 10px;
      }
      .info-label {
        font-size: 0.9em;
        opacity: 0.7;
        margin-bottom: 5px;
      }
      .info-value {
        font-size: 1.1em;
        font-weight: 600;
      }
      .notification-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        margin-bottom: 15px;
      }
      .notification-icon {
        font-size: 1.5em;
        color: #afa55f;
      }
      .edit-btn {
        background: linear-gradient(135deg, #7b5b84, #afa55f);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 20px;
      }
      .edit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(123, 91, 132, 0.3);
      }
      @media (max-width: 768px) {
        .contact-content,
        .profile-content {
          grid-template-columns: 1fr;
          gap: 18px;
          max-width: 100vw;
          margin: 0;
        }
        .profile-card {
          border-radius: 20px !important;
          width: 100%;
          max-width: 100vw;
          box-sizing: border-box;
        }
        .contact-info,
        .contact-form {
          max-width: 100vw;
          min-width: 0;
          padding: 18px 8px;
        }
        .cart-content {
          grid-template-columns: 1fr;
          gap: 18px;
          max-width: 100vw;
          margin: 0 auto;
          justify-content: center;
        }
        .cart-items,
        .cart-summary {
          max-width: 400px;
          min-width: 0;
          margin: 0 auto 18px auto;
          padding: 18px 8px;
        }
        .info-grid {
          grid-template-columns: 1fr;
        }
        .profile-tabs {
          flex-direction: column;
        }
      }
      /* Contacto: grid y responsividad mejorada */
      .contact-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
      }
      @media (max-width: 900px) {
        .contact-form-grid {
          grid-template-columns: 1fr;
        }
      }
      .contact-form {
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
      }
      .profile-card .stat-label a {
        display: block;
        margin-bottom: 2px;
      }
    </style>
  </head>
  <body>
    <header class="header">
      <div class="container header-container">
        <div class="logo-container">
          <a href="#inicio" onclick="showSection('inicio'); return false;"><img src="./public/assets/img/LogoPrincipal.png" alt="Logo" class="logo"/></a>
          <h1 class="site-title">zona-UTP</h1>
        </div>

        <div class="search-container">
          <input
            type="text"
            class="search-input"
            placeholder="Buscar productos..."
          />
          <button class="search-button">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <button class="hamburger-menu" id="hamburger-menu">
          <i class="fas fa-bars"></i>
        </button>
        <nav class="nav" id="nav">
          <ul class="nav-list">
            <li class="nav-item">
              <a class="nav-link" href="#inicio" onclick="showSection('inicio'); return false;">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#productos" onclick="showSection('productos'); return false;">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contacto" onclick="showSection('contacto'); return false;">Contacto</a>
            </li>
          </ul>
        </nav>
        <div class="user-menu">
          <i class="fas fa-user-circle" id="user-icon"></i>
          <div class="user-options" id="user-options">
            <?php if (isset($_SESSION['usuario_id'])): ?>
              <a href="#perfil" class="user-option" onclick="showSection('perfil'); return false;">
                <i class="fas fa-user"></i> Perfil
              </a>
              <a href="#carrito" class="user-option" onclick="showSection('carrito'); return false;">
                <i class="fas fa-shopping-cart"></i> Carrito
              </a>
              <?php
                // Mostrar "Bandeja/Mensajería" solo para admin (tipo 1)
                $isAdmin = false;
                if (isset($_SESSION['usuario_id'])) {
                    $conn = new mysqli($host, $username, $password, $database);
                    if (!$conn->connect_error) {
                      $stmt = $conn->prepare("SELECT tipo_usuario_id FROM Usuarios WHERE id = ?");
                      $stmt->bind_param("i", $_SESSION['usuario_id']);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      if ($row = $result->fetch_assoc()) {
                        if (isset($row['tipo_usuario_id']) && $row['tipo_usuario_id'] == 1) {
                            $isAdmin = true;
                        }
                      }
                      $stmt->close();
                      $conn->close();
                    }
                }
                if ($isAdmin):
              ?>
                <a href="#mensajeria" class="user-option" onclick="showSection('mensajeria'); return false;">
                  <i class="fas fa-envelope"></i> Mensajería
                </a>
              <?php endif; ?>
              <a href="#" class="user-option-logout" id="logout-link">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
              </a>
            <?php else: ?>
              <a href="./public/assets/login.php" class="user-option">
                <i class="fas fa-user"></i> Iniciar sesión
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </header>

    <main>
      <div id="spa-content">
        <section id="inicio" class="spa-section active">
          <div class="banner" style="background: url('./public/assets/img/banner2.png') no-repeat center center/cover; min-height: 320px; display: flex; align-items: center; justify-content: center; text-align: center;">
            <div class="container banner-container" style="background: rgba(0,0,0,0.10); padding: 32px 0; border-radius: 18px;">
              <h2 class="banner-title" style="color:#fff; text-shadow:2px 2px 8px #000;">
                <?php if ($filtro_nombre): ?>
                  ¡Hey, bienvenido <?php echo htmlspecialchars($filtro_nombre); ?> !
                <?php else: ?>
                  ¡Hey, bienvenido a Zona-UTP!
                <?php endif; ?>
              </h2>
              <p class="banner-text" style="color:#fff; text-shadow:1px 1px 6px #000;">Más que solo merch, aquí encuentras estilo universitario con actitud. ¿Listo para llevar tu orgullo UTP al siguiente nivel? 🚀</p>
              <button class="banner-button" onclick="showSection('productos')">Explora nuestros productos</button>
            </div>
          </div>
          <!-- Productos Destacados debajo del banner -->
          <section class="productos-destacados">
            <div class="container">
              <h3 class="section-title">Productos Destacados</h3>
              <!-- Carrusel Accesorios -->
              <div class="carrusel-original" id="carrusel-accesorios">
                <div class="carrusel-track-original auto-carrusel" id="track-accesorios">
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/accesorios/termo.png" alt="Termo" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Termo<br><span>$12.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/accesorios/llavero.png" alt="Llavero" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Llavero<br><span>$5.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/accesorios/bolsa1.png" alt="Bolsa" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Bolsa<br><span>$8.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/accesorios/taza.png" alt="Taza" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Taza<br><span>$7.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/accesorios/Portacredenciales.png" alt="Portacredenciales" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Portacredenciales<br><span>$6.00</span></div></div>
                  </div>
                </div>
              </div>
              <!-- Carrusel Oficina -->
              <div class="carrusel-original" id="carrusel-oficina">
                <div class="carrusel-track-original auto-carrusel" id="track-oficina">
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/oficina/cuaderno.png" alt="Cuaderno" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Cuaderno<br><span>$6.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/oficina/libreta.png" alt="Libreta" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Libreta<br><span>$5.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/oficina/Calendario.png" alt="Calendario" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Calendario<br><span>$4.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/oficina/alfombrilla.png" alt="Alfombrilla" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Alfombrilla<br><span>$3.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/oficina/Folder.png" alt="Folder" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Folder<br><span>$2.00</span></div></div>
                  </div>
                </div>
              </div>
              <!-- Carrusel Ropa -->
              <div class="carrusel-original" id="carrusel-ropa">
                <div class="carrusel-track-original auto-carrusel" id="track-ropa">
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/ropa/jacket_negro.png" alt="Chaqueta Negra" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Chaqueta Negra<br><span>$15.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/ropa/gorra_negra.png" alt="Gorra Negra" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Gorra Negra<br><span>$10.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/ropa/sueter.png" alt="Suéter" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Suéter<br><span>$18.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/ropa/chaqueta_mujer.png" alt="Chaqueta Mujer" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Chaqueta Mujer<br><span>$16.00</span></div></div>
                  </div>
                  <div class="card-carrusel">
                    <img src="./public/assets/img/merch/ropa/jacket_blanco.png" alt="Chaqueta Blanca" />
                    <div class="overlay-carrusel"><div class="info-carrusel">Chaqueta Blanca<br><span>$15.00</span></div></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
    <style>
      .carrusel-original { position: relative; padding: 0; background: #fff; border-radius: 22px; box-shadow: 0 8px 32px rgba(123,91,132,0.10); margin-bottom: 38px; overflow: hidden; }
      .carrusel-titulo { font-size: 1.4em; font-weight: 700; margin: 0 0 18px 0; display: flex; align-items: center; gap: 12px; padding: 18px 0 0 18px; }
      .auto-carrusel { display: flex; gap: 32px; overflow: hidden; height: 320px; align-items: stretch; transition: transform 0.3s; }
      .card-carrusel { min-width: 320px; max-width: 320px; height: 100%; border-radius: 18px; box-shadow: 0 4px 24px rgba(175,165,95,0.10); position: relative; overflow: hidden; display: flex; align-items: flex-end; justify-content: center; background: linear-gradient(135deg,#f8f9fa 60%,#e9ecef 100%); transition: transform 0.2s, box-shadow 0.2s; }
      .card-carrusel img { width: 100%; height: 100%; object-fit: cover; border-radius: 18px; filter: brightness(0.98) contrast(1.08); transition: filter 0.3s; }
      .card-carrusel:hover img { filter: brightness(1.08) contrast(1.15) saturate(1.1); }
      .overlay-carrusel { position: absolute; bottom: 0; left: 0; right: 0; height: 38%; background: linear-gradient(0deg,rgba(123,91,132,0.85) 80%,rgba(123,91,132,0.05) 100%); display: flex; align-items: flex-end; justify-content: center; border-radius: 0 0 18px 18px; }
      .info-carrusel { color: #fff; font-size: 1.25em; font-weight: 600; text-align: center; padding: 18px 0 10px 0; width: 100%; letter-spacing: 0.5px; text-shadow: 0 2px 8px #222; }
      .info-carrusel span { display: block; font-size: 1.1em; font-weight: 700; color: #afa55f; margin-top: 4px; }
      @media (max-width: 1200px) {
        .card-carrusel { min-width: 220px; max-width: 220px; }
        .auto-carrusel { height: 180px; gap: 16px; }
      }
      @media (max-width: 900px) {
        .card-carrusel { min-width: 140px; max-width: 140px; }
        .auto-carrusel { height: 110px; gap: 8px; }
        .carrusel-titulo { font-size: 1.1em; }
      }
    </style>
    <script>
      // Carrusel automático con pausa al pasar el mouse
      function autoDesplazarCarrusel(id, reverse = false) {
        var track = document.getElementById(id);
        if (!track) return;
        let maxScroll = track.scrollWidth - track.clientWidth;
        let scroll = reverse ? maxScroll : 0;
        let dir = reverse ? -1 : 1;
        let paused = false;
        let interval = setInterval(function() {
          if (!paused) {
            scroll += dir * 1.0; // velocidad
            if (!reverse) {
              if (scroll >= maxScroll) dir = -1;
              if (scroll <= 0) dir = 1.0;
            } else {
              if (scroll <= 0) dir = 1.0;
              if (scroll >= maxScroll) dir = -1;
            }
            track.scrollLeft = scroll;
          }
        }, 30);
        // Pausar al pasar el mouse sobre cualquier card
        track.querySelectorAll('.card-carrusel').forEach(function(card) {
          card.addEventListener('mouseenter', function() { paused = true; });
          card.addEventListener('mouseleave', function() { paused = false; });
        });
      }
      document.addEventListener('DOMContentLoaded', function() {
        autoDesplazarCarrusel('track-accesorios');
        autoDesplazarCarrusel('track-oficina', true); // Oficina al contrario
        autoDesplazarCarrusel('track-ropa');
      });
    </script>
          <!-- Sección de Categorías -->
          <section class="categorias">
            <div class="container">
              <h3 class="section-title">Explora por Categorías</h3>
              <div class="categorias-grid">
                <div class="categoria-item">
                  <a href="#productos" onclick="filtrarCategoria('2'); return false;" class="categoria-link" data-categoria="2">
                    <h5 class="categoria-title">Ropa</h5>
                    <p class="categoria-description">Encuentra camisetas, sudaderas, y más.</p>
                  </a>
                </div>
                <div class="categoria-item">
                  <a href="#productos" onclick="filtrarCategoria('1'); return false;" class="categoria-link" data-categoria="1">
                    <h5 class="categoria-title">Accesorios</h5>
                    <p class="categoria-description">Gorras, termos, mochilas y más.</p>
                  </a>
                </div>
                <div class="categoria-item">
                  <a href="#productos" onclick="filtrarCategoria('3'); return false;" class="categoria-link" data-categoria="3">
                    <h5 class="categoria-title">Oficina</h5>
                    <p class="categoria-description">Material de oficina con el logo UTP.</p>
                  </a>
                </div>
              </div>
            </div>
          </section>
        </section>
        <section id="productos" class="spa-section">
          <?php include './public/assets/productos.php'; ?>
        </section>
        <section id="contacto" class="spa-section">
        <?php
          if (!isset($_SESSION['usuario_id'])) {
            include './public/assets/contacto_visitante.php';
          } else {
            include './public/assets/contacto.php';
          }
        ?>
        </section>
        <section id="carrito" class="spa-section">
          <?php include './public/assets/carrito.php'; ?>
        </section>
        <section id="perfil" class="spa-section">
        <?php include './public/assets/perfil.php'; ?>
      </section>
      <section id="mensajeria" class="spa-section">
        <?php include './public/assets/mensajeria.php'; ?>
      </section>
      </div>
    </main>

    <footer class="footer">
      <p class="footer-text">
        Contacto: soporte@utp.ac.pa | Redes Sociales: Facebook, Twitter, Instagram
      </p>
      <p class="footer-text">
        © 2025 UTP Panamá - Todos los derechos reservados.
      </p>
    </footer>
    <!-- Botón para ir arriba -->
    <button id="scrollTopBtn" title="Subir">
      <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Modal de confirmación de logout -->
    <div class="modal-center" id="modalConfirmLogout">
      <div class="modal-content-center">
        <button class="modal-close-center" onclick="closeModal('modalConfirmLogout')">&times;</button>
        <div class="modal-message-center">
          <i class="fas fa-question-circle" style="color:#e67e22;font-size:2em;margin-bottom:10px;"></i>
          <p>¿Estás seguro de cerrar sesión?</p>
          <div style="margin-top:18px;">
            <button id="confirmLogoutBtn" style="margin-right:12px;padding:8px 18px;background:#e74c3c;color:#fff;border:none;border-radius:6px;cursor:pointer;">Sí, cerrar sesión</button>
            <button onclick="closeModal('modalConfirmLogout')" style="padding:8px 18px;background:#ccc;color:#222;border:none;border-radius:6px;cursor:pointer;">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      window.onscroll = function () {
        document.getElementById("scrollTopBtn").style.display =
          window.scrollY > 200 ? "block" : "none";
      };
      document.getElementById("scrollTopBtn").onclick = function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
      };

      function closeModal(id) {
        var modal = document.getElementById(id);
        if (modal) {
          modal.classList.remove('show');
        }
      }
      function showModal(id) {
        var modal = document.getElementById(id);
        if (modal) {
          modal.classList.add('show');
        }
      }

      // SPA: Cambia de sección sin recargar
      function showSection(sectionId) {
        var found = false;
        document.querySelectorAll('.spa-section').forEach(function(sec) {
          if (sec.id === sectionId) {
            sec.classList.add('active');
            found = true;
          } else {
            sec.classList.remove('active');
          }
        });
        // Si no se encontró la sección, muestra inicio por defecto
        if (!found) {
          var inicio = document.getElementById('inicio');
          if (inicio) inicio.classList.add('active');
        }

        // Si es carrito, fuerza la pestaña principal y actualiza
        if (sectionId === 'carrito') {
          var tabBtns = document.querySelectorAll('#carrito .tab-btn');
          var tabContents = document.querySelectorAll('#carrito .tab-content');
          if (tabBtns.length && tabContents.length) {
            tabBtns.forEach(function(btn, idx) {
              btn.classList.toggle('active', idx === 0);
            });
            tabContents.forEach(function(tab, idx) {
              tab.classList.toggle('active', idx === 0);
            });
          }
          if (typeof updateCart === 'function') {
            updateCart();
          }
        }
        // Si es perfil, fuerza la pestaña principal (Perfil)
        if (sectionId === 'perfil') {
          var tabBtns = document.querySelectorAll('#perfil .tab-btn');
          var tabContents = document.querySelectorAll('#perfil .tab-content');
          if (tabBtns.length && tabContents.length) {
            tabBtns.forEach(function(btn, idx) {
              btn.classList.toggle('active', idx === 0);
            });
            tabContents.forEach(function(tab, idx) {
              tab.classList.toggle('active', idx === 0);
            });
          }
          if (typeof updateProfile === 'function') {
            updateProfile();
          }
        }
        // Si es contacto, fuerza la pestaña principal y actualiza
        if (sectionId === 'contacto') {
          var tabBtns = document.querySelectorAll('#contacto .tab-btn');
          var tabContents = document.querySelectorAll('#contacto .tab-content');
          if (tabBtns.length && tabContents.length) {
            tabBtns.forEach(function(btn, idx) {
              btn.classList.toggle('active', idx === 0);
            });
            tabContents.forEach(function(tab, idx) {
              tab.classList.toggle('active', idx === 0);
            });
          }
          if (typeof updateContacto === 'function') {
            updateContacto();
          }
        }
        // Elimina el hash de la URL para evitar scroll/jump
        if (window.history && window.history.replaceState) {
          window.history.replaceState(null, '', window.location.pathname);
        }
      }

      // Enlaces del nav: SPA
      document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nav-link').forEach(function(link) {
          link.addEventListener('click', function(e) {
            e.preventDefault();
            var section = link.getAttribute('href').replace('#','');
            showSection(section);
          });
        });
      });

      document.addEventListener('DOMContentLoaded', function () {
        const logoutLink = document.getElementById('logout-link');
        const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');

        if (logoutLink) {
          logoutLink.addEventListener('click', function (e) {
            e.preventDefault();
            showModal('modalConfirmLogout');
          });
        }
        if (confirmLogoutBtn) {
          confirmLogoutBtn.addEventListener('click', function () {
            window.location.href = './config/logout.php';
          });
        }
      });
    </script>
  </body>
</html>