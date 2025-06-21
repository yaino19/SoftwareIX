<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZonaUTP - Registro</title>
    <link rel="stylesheet" href="/public/assets/css/registro_usuario.css" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" href="../img/LogoPrincipal.png" />
  </head>
  <body>
    <div class="registro-card-split">
      <div class="registro-left">
        <div class="profile-icon-bg">
          <i class="fas fa-user"></i>
          <span class="profile-plus"><i class="fas fa-plus"></i></span>
        </div>
        <h2>¡Bienvenido!</h2>
        <p>
          Únete a ZonaUTP y accede a los beneficios de la comunidad
          universitaria.
        </p>
      </div>
      <div class="registro-right">
        <form class="login-form" id="registerForm" autocomplete="off">
          <div class="registro-form-grid">
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <div class="input-container">
                <i class="fas fa-user input-icon"></i>
                <input
                  type="text"
                  id="nombre"
                  name="nombre"
                  placeholder="Nombre"
                  required
                  autocomplete="given-name"
                />
              </div>
            </div>
            <div class="form-group">
              <label for="apellido">Apellido</label>
              <div class="input-container">
                <i class="fas fa-user input-icon"></i>
                <input
                  type="text"
                  id="apellido"
                  name="apellido"
                  placeholder="Apellido"
                  required
                  autocomplete="family-name"
                />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <div class="input-container">
              <i class="fas fa-user-tag input-icon"></i>
              <input
                type="text"
                id="username"
                name="username"
                placeholder="Nombre de usuario"
                required
                autocomplete="username"
              />
            </div>
          </div>
          <div class="form-group">
            <label for="correo">Correo</label>
            <div class="input-container">
              <i class="fas fa-envelope input-icon"></i>
              <input
                type="email"
                id="correo"
                name="correo"
                placeholder="correo@ejemplo.com"
                required
                autocomplete="email"
              />
            </div>
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
                autocomplete="new-password"
              />
              <i
                class="fas fa-eye-slash toggle-password"
                id="togglePassword"
              ></i>
            </div>
          </div>
          <div
            class="form-group"
            style="margin: 24px 0 12px 0; text-align: center"
          >
            <div style="display: flex; align-items: center; gap: 10px">
              <hr
                style="flex: 1; border: none; border-top: 1px solid #e2e8f0"
              />
              <span style="color: #a0aec0; font-weight: 600; font-size: 0.95em"
                >o</span
              >
              <hr
                style="flex: 1; border: none; border-top: 1px solid #e2e8f0"
              />
            </div>
            <button
              type="button"
              id="googleLoginBtn"
              class="google-btn"
              style="
                margin-top: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
                background: #fff;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                padding: 10px 0;
                font-weight: 600;
                color: #334155;
                font-size: 1em;
                cursor: pointer;
                transition: box-shadow 0.2s;
              "
            >
              <i
                class="fab fa-google"
                style="color: #ea4335; font-size: 1.2em"
              ></i>
              Registrarse con Google
            </button>
          </div>
          <button type="submit" class="login-button" id="registerButton">
            <span class="button-text">Registrarse</span>
            <i class="fas fa-user-plus button-icon"></i>
          </button>
        </form>
        <div class="login-footer">
          ¿Ya tienes cuenta?
          <a href="login.html" class="login-link">Inicia sesión aquí</a>
        </div>
      </div>
    </div>
    <!-- Modal de éxito -->
    <div id="exitoModal" class="modal" style="display: none">
      <div class="modal-content">
        <span class="close-modal" id="closeExitoModal">&times;</span>
        <div class="modal-success-icon">
          <i class="fas fa-check"></i>
        </div>
        <p id="exitoMensaje">
          ¡Registro exitoso!<br />Serás redirigido al inicio de sesión.
        </p>
      </div>
    </div>
    <script src="../js/registro_usuario.js"></script>
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
        const googleBtn = document.getElementById('googleLoginBtn');
        if (googleBtn) {
          googleBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            try {
              const result = await signInWithPopup(auth, provider);
              // Usuario autenticado con Google
              const user = result.user;
              // Mostrar modal de éxito y redirigir
              const modal = document.getElementById('exitoModal');
              modal.style.display = 'flex';
              setTimeout(() => {
                modal.style.display = 'none';
                window.location.href = "login.html";
              }, 2000);
            } catch (error) {
              alert('Error de autenticación con Google: ' + error.message);
            }
          });
        }
      });
    </script>
  </body>
</html>
