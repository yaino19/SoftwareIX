document.addEventListener('DOMContentLoaded', () => {
    const esEstudianteUTP = document.getElementById('esEstudianteUTP');
    const labelIdentidad = document.getElementById('labelIdentidad');
    const inputIdentidadContainer = document.getElementById('inputIdentidadContainer');
    const iconoIdentidad = document.getElementById('iconoIdentidad');
    const recordarUsuario = document.getElementById('rememberMe');
    const formularioLogin = document.getElementById('loginForm');
    const errorCorreo = document.getElementById('emailError');
    let inputIdentidad = document.getElementById('identidad');

    function crearInput(tipo, nombre, placeholder, autocomplete) {
        const input = document.createElement('input');
        input.type = tipo;
        input.id = 'identidad';
        input.name = nombre;
        input.placeholder = placeholder;
        input.required = true;
        input.autocomplete = autocomplete;
        input.className = 'input-identidad';
        return input;
    }

    esEstudianteUTP.addEventListener('change', function () {
        inputIdentidadContainer.removeChild(inputIdentidad);

        if (this.checked) {
            labelIdentidad.textContent = 'Correo Institucional';
            iconoIdentidad.className = 'fas fa-envelope input-icon';
            inputIdentidad = crearInput('email', 'email', 'usuario@utp.ac.pa', 'email');
        } else {
            labelIdentidad.textContent = 'Nombre de usuario';
            iconoIdentidad.className = 'fas fa-user input-icon';
            inputIdentidad = crearInput('text', 'username', 'Tu nombre de usuario', 'username');
        }
        inputIdentidadContainer.appendChild(inputIdentidad);

        // Limpiar errores y valor
        if (errorCorreo) errorCorreo.textContent = '';
        inputIdentidad.style.borderColor = '#e2e8f0';
        inputIdentidad.value = '';
    });

    function validarIdentidad() {
        const valor = inputIdentidad.value.trim();
        inputIdentidad.style.borderColor = '#e2e8f0';
        if (errorCorreo) errorCorreo.textContent = '';

        if (!valor) {
            if (errorCorreo) errorCorreo.textContent = esEstudianteUTP.checked ? 'El correo es requerido' : 'El nombre de usuario es requerido';
            inputIdentidad.style.borderColor = '#ef4444';
            return false;
        }
        if (esEstudianteUTP.checked) {
            const regexUTP = /^[a-zA-Z0-9._%+-]+@utp\.ac\.pa$/;
            if (!regexUTP.test(valor)) {
                if (errorCorreo) errorCorreo.textContent = 'Debe usar un correo institucional válido (@utp.ac.pa)';
                inputIdentidad.style.borderColor = '#ef4444';
                return false;
            }
        }
        return true;
    }

    inputIdentidadContainer.addEventListener('input', function(e) {
        if (e.target.id === 'identidad') validarIdentidad();
    });
    inputIdentidadContainer.addEventListener('blur', function(e) {
        if (e.target.id === 'identidad') validarIdentidad();
    }, true);

    // Cargar usuario guardado si existe
    const usuarioGuardado = localStorage.getItem('rememberedUser');
    if (usuarioGuardado) {
        inputIdentidad.value = usuarioGuardado;
        recordarUsuario.checked = true;
    }

    formularioLogin.addEventListener('submit', function(e) {
        if (!validarIdentidad()) {
            e.preventDefault();
        } else {
            if (recordarUsuario.checked) {
                localStorage.setItem('rememberedUser', inputIdentidad.value.trim());
            } else {
                localStorage.removeItem('rememberedUser');
            }
        }
    });
});
const googleBtnBlock = document.getElementById('googleBtnBlock');
    if (googleBtnBlock) {
        // Inicialmente oculto si está seleccionado "Correo Institucional"
        googleBtnBlock.style.display = esEstudianteUTP.checked ? 'none' : 'block';

        esEstudianteUTP.addEventListener('change', function () {
            googleBtnBlock.style.display = this.checked ? 'none' : 'block';
        });
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