<?php
if (!isset($_SESSION)) session_start();  

$filtro_nombre = null;
if (isset($_SESSION['usuario_id'])) {
    $host = "localhost";
    $username = "jasonpty";
    $password = "jason27278";
    $database = "db_zonautp";
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
    <link rel="stylesheet" href="./public/assets/css/style.css" />
    <script src="./public/assets/js/main.js" defer></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="icon" href="./public/assets/img/LogoPrincipal.png" type="image/png" />
    <style>
      body {
            font-family: 'Inter', Arial, Helvetica, sans-serif;
          }

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
    </style>
  </head>
  <body>
    <header class="header">
      <div class="container header-container">
        <div class="logo-container">
          <img src="./public/assets/img/LogoPrincipal.png" alt="Logo" class="logo"/>
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
              <a class="nav-link" href="./index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../SoftwareIX/public/assets/productos.php">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contacto.html">Contacto</a>
            </li>
          </ul>
        </nav>
        <div class="user-menu">
          <i class="fas fa-user-circle" id="user-icon"></i>
          <div class="user-options" id="user-options">
            <?php if (isset($_SESSION['usuario_id'])): ?>
              <a href="perfil.html" class="user-option">
                <i class="fas fa-user"></i> Perfil
              </a>
              <a href="carrito.html" class="user-option">
                <i class="fas fa-shopping-cart"></i> Carrito
              </a>
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
      <!-- Sección de Banner con imágenes -->
      <section class="banner">
        <div class="container banner-container">
          <h2 class="banner-title">
            <?php if ($filtro_nombre): ?>
              ¡Hey, bienvenido <?php echo htmlspecialchars($filtro_nombre); ?> !
            <?php else: ?>
              ¡Hey, bienvenido a Zona-UTP!
            <?php endif; ?>
          </h2>
          <p class="banner-text">
            Más que solo merch, aquí encuentras estilo universitario con
            actitud. ¿Listo para llevar tu orgullo UTP al siguiente nivel? 🚀
          </p>
          <button class="banner-button">Explora nuestros productos</button>
        </div>
      </section>

      <!-- Sección de Productos Destacados -->
      <section class="productos-destacados">
        <div class="container">
          <h3 class="section-title">Productos Destacados</h3>
          <div class="carrusel-sombra">
            <div class="productos-grid">
              <div class="producto-card">
                <img src="./public/assets/img/merch/ropa/jacket_negro.png" class="producto-img" alt="Chaqueta UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Chaquetas UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$15.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/ropa/gorra_negra.png" class="producto-img" alt="Gorra UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Gorra UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$10.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/accesorios/termo.png" class="producto-img" alt="Termo UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Termo UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$12.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/accesorios/llavero.png" class="producto-img" alt="Llavero UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Llaveros UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$25.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/accesorios/bolsa1.png" class="producto-img" alt="Bolsa UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Bolsa UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$25.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/ropa/jacket_negro.png" class="producto-img" alt="Chaqueta UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Chaquetas UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$15.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/ropa/gorra_negra.png" class="producto-img" alt="Gorra UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Gorra UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$10.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/accesorios/termo.png" class="producto-img" alt="Termo UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Termo UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$12.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/accesorios/llavero.png" class="producto-img" alt="Llavero UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Llaveros UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$25.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
              <div class="producto-card">
                <img src="./public/assets/img/merch/accesorios/bolsa1.png" class="producto-img" alt="Bolsa UTP" />
                <div class="producto-info">
                  <h5 class="producto-title">Bolsa UTP</h5>
                  <p class="producto-description"></p>
                  <p class="producto-price">$25.00</p>
                  <button class="producto-button">
                    Añadir <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Sección de Categorías -->
      <section class="categorias">
        <div class="container">
          <h3 class="section-title">Explora por Categorías</h3>
          <div class="categorias-grid">
            <div class="categoria-item">
              <a href="../productos.html"></a>
              <h5 class="categoria-title">Ropa</h5>
              <p class="categoria-description">
                Encuentra camisetas, sudaderas, y más.
              </p>
            </div>
            <div class="categoria-item">
              <a href="productos.html"></a>
              <h5 class="categoria-title">Accesorios</h5>
              <p class="categoria-description">
                Gorras, termos, mochilas y más.
              </p>
            </div>
            <div class="categoria-item">
              <a href="productos.html"></a>
              <h5 class="categoria-title">Oficina</h5>
              <p class="categoria-description">
                Material de oficina con el logo UTP.
              </p>
            </div>
          </div>
        </div>
      </section>
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