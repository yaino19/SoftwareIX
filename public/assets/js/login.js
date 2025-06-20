document.addEventListener('DOMContentLoaded', () => {
    const formularioLogin = document.getElementById('loginForm');
    const inputCorreo = document.getElementById('email');
    const errorCorreo = document.getElementById('emailError');
    const recordarUsuario = document.getElementById('rememberMe');

    // Cargar correo guardado si existe
    const correoGuardado = localStorage.getItem('rememberedEmail');
    if (correoGuardado) {
        inputCorreo.value = correoGuardado;
        recordarUsuario.checked = true;
    }

    // Validar correo institucional
    function validarCorreo() {
        const correo = inputCorreo.value.trim();
        const regexUTP = /^[a-zA-Z0-9._%+-]+@utp\.ac\.pa$/;
        errorCorreo.textContent = '';
        inputCorreo.style.borderColor = '#e2e8f0';

        if (!correo) {
            errorCorreo.textContent = 'El correo es requerido';
            inputCorreo.style.borderColor = '#ef4444';
            return false;
        }
        if (!regexUTP.test(correo)) {
            errorCorreo.textContent = 'Debe usar un correo institucional válido (@utp.ac.pa)';
            inputCorreo.style.borderColor = '#ef4444';
            return false;
        }
        return true;
    }

    inputCorreo.addEventListener('input', validarCorreo);
    inputCorreo.addEventListener('blur', validarCorreo);

    formularioLogin.addEventListener('submit', function(e) {
        if (!validarCorreo()) {
            e.preventDefault();
        } else {
            if (recordarUsuario.checked) {
                localStorage.setItem('rememberedEmail', inputCorreo.value.trim());
            } else {
                localStorage.removeItem('rememberedEmail');
            }
        }
    });
});