<?php
if (!isset($_SESSION)) session_start();
$showModal = isset($_SESSION['showModal']) ? $_SESSION['showModal'] : false;
$blockModal = isset($_SESSION['blockModal']) ? $_SESSION['blockModal'] : false;
$remainingTime = isset($_SESSION['remainingTime']) ? $_SESSION['remainingTime'] : 0;
unset($_SESSION['showModal'], $_SESSION['blockModal'], $_SESSION['remainingTime']);

$logoutModal = isset($_GET['logout']) && $_GET['logout'] == 1;

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZonaUTP - Iniciar Sesión</title>
    <link rel="stylesheet" href="./css/login.css"/>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" href="./img/LogoPrincipal.png" />
    <style>
          body {
            font-family: 'Inter', Arial, Helvetica, sans-serif;
          }

        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 520px;
            padding: 20px;
            z-index: 10;
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
      @keyframes fadeInModal {
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
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
    </style>
  </head>
  <body style="background: url('./img/fondoLogin.png') no-repeat center center fixed; background-size: cover;">
    <?php if ($showModal): ?>
      <div class="modal-center show" id="modalError">
        <div class="modal-content-center">
          <button class="modal-close-center" onclick="closeModal('modalError')">&times;</button>
          <div class="modal-message-center">
            <i class="fas fa-exclamation-circle" style="color:#e74c3c;font-size:2em;margin-bottom:10px;"></i>
            <p>El correo o la contraseña son incorrectos.</p>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if ($blockModal): ?>
      <div class="modal-center show" id="modalBlock">
        <div class="modal-content-center">
          <button class="modal-close-center" onclick="closeModal('modalBlock')">&times;</button>
          <div class="modal-message-center">
            <i class="fas fa-ban" style="color:#e67e22;font-size:2em;margin-bottom:10px;"></i>
            <p>Has excedido el número de intentos permitidos.<br>
            Inténtalo de nuevo en <?php echo ceil($remainingTime / 60); ?> minutos.</p>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="login-container">
      <div class="login-card">
        <div class="login-header">
          <div class="logo-container">
            <img src="./img/LogoPrincipal.png" alt="Logo UTP" class="logo" />
          </div>
        </div>
        <form method="POST" action="../../src/controller/auth.php" id="loginForm">
          <div class="form-group">
            <label class="custom-checkbox">
              <input type="checkbox" id="esEstudianteUTP" checked />
              <span class="checkmark"></span>
              ¿Eres estudiante de la universidad?
            </label>
          </div>

          <div class="form-group" id="grupoIdentidad">
            <label for="identidad" id="labelIdentidad">Correo Institucional</label>
            <div class="input-container" id="inputIdentidadContainer">
              <i class="fas fa-envelope input-icon" id="iconoIdentidad"></i>
              <input
                type="email"
                id="identidad"
                name="email"
                placeholder="Tu correo institucional"
                required
                autocomplete="email"
              />
            </div>
            <span id="emailError" style="color:#e74c3c;font-size:0.95em;"></span>
          </div>

          <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-container">
              <i class="fas fa-lock input-icon"></i>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="•••••"
                required
                autocomplete="current-password"
              />
            </div>
          </div>

          <div class="form-options">
            <label
              class="custom-checkbox"
              style="cursor: pointer; user-select: none"
            >
              <i
                class="fas fa-eye-slash toggle-password"
                id="togglePassword"
                style="margin-right: 8px"
              ></i>
              Mostrar contraseña
            </label>
            <a href="./recuperar_contra.php" class="forgot-password"
              >¿Olvidaste tu contraseña?</a
            >
          </div>

          <button type="submit" class="login-button" id="loginButton">
            <span class="button-text">Iniciar Sesión</span>
            <i class="fas fa-arrow-right button-icon"></i>
          </button>
          <!-- Botón Google debajo de Iniciar Sesión -->
          <div id="googleBtnBlock" style="display:none; margin-top:10px;">
            <button
              type="button"
              id="googleLoginBtn"
              class="google-btn"
              style="
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                width: 100%;
                background: #fff;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 10px 0;
                font-weight: 600;
                color: #334155;
                font-size: 0.98em;
                cursor: pointer;
                transition: box-shadow 0.2s;
                min-height: 44px;
              "
            >
              <i class="fab fa-google" style="color: #ea4335; font-size: 1.1em"></i>
              Iniciar sesión con Google
            </button>
          </div>
        </form>
        <div class="login-footer">
          <p>
            ¿No tienes cuenta?
            <a href="./registro_usuario.php" class="register-link">Regístrate aquí</a>
          </p>
          <p class="university-info">Universidad Tecnológica de Panamá</p>
        </div>
      </div>
    </div>

    <script src="./js/login.js"></script>
    <script>
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
      // Mostrar/ocultar contraseña
document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const isVisible = passwordInput.type === 'text';
            passwordInput.type = isVisible ? 'password' : 'text';
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
});
    
    </script>
    <script type="module">
      import { initializeApp } from "https://www.gstatic.com/firebasejs/11.9.1/firebase-app.js";
      import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.9.1/firebase-analytics.js";
      import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/11.9.1/firebase-auth.js";

      const firebaseConfig = {
        apiKey: "AIzaSyAXsyFcYCIqk_k_pHLTwoPSDEzd_RdFlUc",
        authDomain: "ecommerce-utp.firebaseapp.com",
        projectId: "ecommerce-utp",
        storageBucket: "ecommerce-utp.firebasestorage.app",
        messagingSenderId: "49844622966",
        appId: "1:49844622966:web:5154fe4abb24614bea3157",
        measurementId: "G-01BMCL2E9P"
      };

      const app = initializeApp(firebaseConfig);
      const analytics = getAnalytics(app);

      // Google Auth
      const auth = getAuth(app);
      const provider = new GoogleAuthProvider();

      document.addEventListener('DOMContentLoaded', () => {
        // Mostrar/ocultar el botón de Google según el tipo de login
        const esEstudianteUTP = document.getElementById('esEstudianteUTP');
        const googleBtnBlock = document.getElementById('googleBtnBlock');
        if (googleBtnBlock && esEstudianteUTP) {
          googleBtnBlock.style.display = esEstudianteUTP.checked ? 'none' : 'block';
          esEstudianteUTP.addEventListener('change', function () {
            googleBtnBlock.style.display = this.checked ? 'none' : 'block';
          });
        }
        const googleBtn = document.getElementById('googleLoginBtn');
        if (googleBtn) {
          googleBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            try {
              const result = await signInWithPopup(auth, provider);
              const user = result.user;
              // Enviar datos a login_google_controller.php
              const response = await fetch('login_google_controller.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: user.email, uid: user.uid, nombre: user.displayName || '' })
              });
              const data = await response.json();
              if (data.success) {
                // Redirigir a la página principal
                window.location.href = '../../index.php';
              } else {
                // Mostrar modal de error personalizado
                mostrarModalGoogle(data.message || 'No existe una cuenta asociada a este Google. Por favor regístrate.');
              }
            } catch (error) {
              mostrarModalGoogle('Error de autenticación con Google: ' + error.message);
            }
          });
        }
      });

      // Modal Google sencillo para login
      function mostrarModalGoogle(mensaje) {
        let modal = document.getElementById('modalGoogleLogin');
        if (!modal) {
          modal = document.createElement('div');
          modal.id = 'modalGoogleLogin';
          modal.className = 'modal-center show';
          modal.innerHTML = `
            <div class="modal-content-center">
              <button class="modal-close-center" onclick="document.getElementById('modalGoogleLogin').classList.remove('show')">&times;</button>
              <div class="modal-message-center">
                <i class="fab fa-google" style="color:#ea4335;font-size:2em;margin-bottom:10px;"></i>
                <p>${mensaje}</p>
              </div>
            </div>
          `;
          document.body.appendChild(modal);
        } else {
          modal.querySelector('p').innerHTML = mensaje;
          modal.classList.add('show');
        }
      }  
    </script>
    <?php if ($logoutModal): ?>
  <div class="modal-center show" id="modalLogout">
    <div class="modal-content-center">
      <button class="modal-close-center" onclick="closeModal('modalLogout'); window.history.replaceState({}, document.title, window.location.pathname);">&times;</button>
      <div class="modal-message-center">
        <i class="fas fa-check-circle" style="color:#27ae60;font-size:2em;margin-bottom:10px;"></i>
        <p>Has cerrado sesión correctamente.</p>
      </div>
    </div>
  </div>
  <script>
    // Elimina ?logout=1 de la URL al cerrar el modal para que no vuelva a aparecer
    document.addEventListener('DOMContentLoaded', function() {
      var closeBtn = document.querySelector('#modalLogout .modal-close-center');
      if (closeBtn) {
        closeBtn.addEventListener('click', function() {
          window.history.replaceState({}, document.title, window.location.pathname);
        });
      }
    });
  </script>
<?php endif; ?>
  </body>
</html>