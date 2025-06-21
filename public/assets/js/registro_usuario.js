document.addEventListener('DOMContentLoaded', () => {
  // Mostrar/ocultar contraseña
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

  const form = document.getElementById('registerForm');
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    // Aquí se agregaran validaciones extra o enviar datos al backend

    // Mostrar modal de éxito
    const modal = document.getElementById('exitoModal');
    modal.style.display = 'flex';

    document.getElementById('closeExitoModal').onclick = function() {
      modal.style.display = 'none';
      window.location.href = "login.html";
    };
    setTimeout(() => {
      modal.style.display = 'none';
      window.location.href = "login.html";
    }, 2000);
    window.onclick = function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
        window.location.href = "login.html";
      }
    };
  });
});