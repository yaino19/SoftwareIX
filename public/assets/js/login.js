document.addEventListener('DOMContentLoaded', () => {
    const esEstudianteUTP = document.getElementById('esEstudianteUTP');
    const labelIdentidad = document.getElementById('labelIdentidad');
    const inputIdentidadContainer = document.getElementById('inputIdentidadContainer');
    const iconoIdentidad = document.getElementById('iconoIdentidad');
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
        inputIdentidad = crearInput('email', 'email', 'Tu correo institucional', 'email');
    } else {
        labelIdentidad.textContent = 'Correo electrónico';
        iconoIdentidad.className = 'fas fa-envelope input-icon';
        inputIdentidad = crearInput('email', 'email', 'Tu correo electrónico', 'email');
    }
    inputIdentidadContainer.appendChild(inputIdentidad);

    if (errorCorreo) errorCorreo.textContent = '';
    inputIdentidad.style.borderColor = '#e2e8f0';
    inputIdentidad.value = '';
});

    function validarIdentidad() {
        const valor = inputIdentidad.value.trim();
        inputIdentidad.style.borderColor = '#e2e8f0';
        if (errorCorreo) errorCorreo.textContent = '';

        if (!valor) {
            if (errorCorreo) errorCorreo.textContent = 'El correo es requerido';
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
        } else {
            // Validar correo general
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regexEmail.test(valor)) {
                if (errorCorreo) errorCorreo.textContent = 'Ingrese un correo válido';
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

    formularioLogin.addEventListener('submit', function(e) {
        if (!validarIdentidad()) {
            e.preventDefault();
        }
    });

    // Google button show/hide
    const googleBtnBlock = document.getElementById('googleBtnBlock');
    if (googleBtnBlock && esEstudianteUTP) {
        googleBtnBlock.style.display = esEstudianteUTP.checked ? 'none' : 'block';
        esEstudianteUTP.addEventListener('change', function () {
            googleBtnBlock.style.display = this.checked ? 'none' : 'block';
        });
    }
});

