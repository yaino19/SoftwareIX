<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZonaUTP - Registro</title>
    <link rel="stylesheet" href="./css/registro_usuario.css" />
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
      .google-btn-simple {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: #f5f5f5;
        border: 1.5px solid #e2e8f0;
        border-radius: var(--border-radius);
        padding: 10px 0;
        font-weight: 600;
        color: #444;
        font-size: 1em;
        cursor: pointer;
        box-shadow: none;
        margin-bottom: 0;
        margin-top: 0;
        transition: background 0.18s, border-color 0.18s;
      }
      .google-btn-simple:hover,
      .google-btn-simple:focus {
        background: #ececec;
        border-color: #d1d5db;
        color: #222;
      }
      .google-btn-simple i.fab.fa-google {
        color: #ea4335;
        font-size: 1.2em;
        background: transparent;
        border-radius: 50%;
        padding: 2px;
      }
      /* Modal Google sencillo */
      .modal-google {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0; top: 0;
        width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.18);
        justify-content: center;
        align-items: center;
      }
      .modal-google-content {
        background: #fff;
        padding: 28px 22px 22px 22px;
        border-radius: 12px;
        text-align: center;
        position: relative;
        min-width: 260px;
        max-width: 95vw;
        box-shadow: 0 4px 18px rgba(60,60,60,0.10);
        border: 1.5px solid #e2e8f0;
      }
      .close-modal-google {
        position: absolute;
        right: 12px;
        top: 8px;
        font-size: 1.3em;
        cursor: pointer;
        color: #888;
      }
      .modal-google-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
      }
      .modal-google-icon i {
        font-size: 2.2em;
        color: #ea4335;
        background: #f5f5f5;
        border-radius: 50%;
        padding: 8px;
      }
      .modal-google-success {
        color: #222;
        font-size: 1em;
        margin-bottom: 8px;
      }
      .modal-google-link {
        display: inline-block;
        margin-top: 8px;
        color: #ea4335;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.98em;
      }
    </style>
  </head>
  <body style="background: url('./img/fondoLogin.png') no-repeat center center fixed; background-size: cover;">
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
        <?php if (isset($_GET['error'])): ?>
          <div class="error-message" style="color: red; margin-bottom: 10px; text-align:center;">
            <?php echo htmlspecialchars($_GET['error']); ?>
          </div>
        <?php endif; ?>
        <form class="login-form" id="registerForm" autocomplete="off" action="register_controller.php" method="POST">
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
                minlength="7"
              />
              <i
                class="fas fa-eye-slash toggle-password"
                id="togglePassword"
                style="cursor:pointer;"
              ></i>
            </div>
          </div>
          <button type="submit" class="login-button" id="registerButton">
            <span class="button-text">Registrarse</span>
            <i class="fas fa-user-plus button-icon"></i>
          </button>
        </form>
        <div class="login-footer">
          ¿Ya tienes cuenta?
          <a href="/SoftwareIX/public/assets/login.php" class="login-link">Inicia sesión aquí</a>
        </div>
      </div>
    </div>
    <!-- Modal Google personalizado -->
<div id="modalGoogle" class="modal-google">
  <div class="modal-google-content">
    <span class="close-modal-google" id="closeModalGoogle">&times;</span>
    <div class="modal-google-icon">
      <i class="fab fa-google"></i>
    </div>
    <p id="modalGoogleMensaje" class="modal-google-success"></p>
    <a href="/SoftwareIX/public/assets/login.php" class="modal-google-link">Ir a iniciar sesión</a>
  </div>
</div>
    <?php if (isset($_GET['success'])): ?>
      <div id="exitoModal" class="modal" style="display: flex; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); z-index:9999;">
        <div class="modal-content" style="background:#fff; padding:30px 40px; border-radius:10px; text-align:center; position:relative; min-width:300px;">
          <span class="close-modal" id="closeExitoModal" style="position:absolute; top:10px; right:15px; font-size:1.5em; cursor:pointer;">&times;</span>
          <div class="modal-success-icon" style="font-size:2.5em; color:green; margin-bottom:10px;">
            <i class="fas fa-check"></i>
          </div>
          <p id="exitoMensaje" style="font-size:1.1em; color:#222; margin-bottom:10px;">
            <?php echo htmlspecialchars($_GET['success']); ?>
          </p>
          <a href="/SoftwareIX/public/assets/login.php" class="login-link" style="display:inline-block; margin-top:10px; color:#4f46e5; font-weight:600;">Ir a iniciar sesión</a>
        </div>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var modal = document.getElementById('exitoModal');
          var closeBtn = document.getElementById('closeExitoModal');
          var redirectToLogin = function() {
            window.location.href = '/SoftwareIX/public/assets/login.php';
          };
          if (closeBtn) {
            closeBtn.onclick = function() {
              modal.style.display = 'none';
              setTimeout(redirectToLogin, 500);
            };
          }
          setTimeout(function() {
            if (modal) modal.style.display = 'none';
            redirectToLogin();
          }, 2000); // Cierra el modal después de 2 segundos
        });
      </script>
    <?php endif; ?>
    <script src="./js/registro_usuario.js"></script>
    <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      var password = document.getElementById('password').value;
      var regexMayuscula = /[A-Z]/;
      var regexSimbolo = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;
      if (password.length < 7) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 7 caracteres.');
        document.getElementById('password').focus();
        return false;
      }
      if (!regexMayuscula.test(password)) {
        e.preventDefault();
        alert('La contraseña debe contener al menos una letra mayúscula.');
        document.getElementById('password').focus();
        return false;
      }
      if (!regexSimbolo.test(password)) {
        e.preventDefault();
        alert('La contraseña debe contener al menos un símbolo (por ejemplo: !, @, #, etc).');
        document.getElementById('password').focus();
        return false;
      }
    });
</script>
  </body>
</html>
