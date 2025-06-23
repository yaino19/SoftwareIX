<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZonaUTP - Recuperar Contraseñaes</title>
    <link rel="stylesheet" href="/public/assets/css/login.css" />
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
  <body style="background: url('./img/fondoLogin.png') no-repeat center center fixed; background-size: cover;">
    <div class="login-container">
      <div class="login-card">
        <div class="login-header">
          <div class="logo-container">
            <img src="../img/LogoPrincipal.png" alt="Logo UTP" class="logo" />
          </div>
          <h3>Recuperar Contraseña</h3>
          <p class="descripcion-recuperar">
            Ingresa tu correo institucional y te enviaremos un código para
            restablecer tu contraseña.<br />
            Revisa tu bandeja de entrada y sigue las instrucciones.
          </p>
        </div>

        <form class="login-form" id="loginForm">
          <div class="form-group">
            <label for="email">Correo Institucional</label>
            <div class="input-container">
              <i class="fas fa-envelope input-icon"></i>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="usuario@utp.ac.pa"
                required
                autocomplete="email"
              />
            </div>
          </div>

          <button type="submit" class="login-button" id="loginButton">
            <span class="button-text">Enviar codigo</span>
            <i class="fas fa-arrow-right button-icon"></i>
          </button>
        </form>
      </div>
    </div>

    <script src="../js/recuperar_contra.js"></script>
    <div id="errorModal" class="modal" style="display: none">
      <div class="modal-content">
        <span class="close-modal" id="closeModal">&times;</span>
        <p id="modalMessage"></p>
      </div>
    </div>
    <div id="exitoModal" class="modal" style="display: none">
      <div class="modal-content">
        <span class="close-modal" id="closeExitoModal">&times;</span>
        <div class="modal-success-icon">
          <i class="fas fa-check"></i>
        </div>
        <p id="exitoMensaje">
          ¡Contraseña modificada exitosamente!<br />Vuelve a iniciar sesión.
        </p>
      </div>
    </div>
  </body>
</html>
