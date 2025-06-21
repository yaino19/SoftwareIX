document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('loginForm');
    let estado = 'correo';

    if (estado === 'correo') {
        formulario.innerHTML = `
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
                        placeholder="usuario@utp.ac.pa"
                        required
                        autocomplete="email"
                    />
                </div>
            </div>
            <button type="submit" class="login-button" id="loginButton">
                <span class="button-text">Enviar código</span>
                <i class="fas fa-arrow-right button-icon"></i>
            </button>
        `;
    }

    let esEstudianteUTP = document.getElementById('esEstudianteUTP');
    let labelIdentidad = document.getElementById('labelIdentidad');
    let inputIdentidadContainer = document.getElementById('inputIdentidadContainer');
    let iconoIdentidad = document.getElementById('iconoIdentidad');
    let inputIdentidad = document.getElementById('identidad');
    let errorCorreo = document.getElementById('emailError');

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

    formulario.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'esEstudianteUTP') {
            inputIdentidadContainer.removeChild(inputIdentidad);

            if (e.target.checked) {
                labelIdentidad.textContent = 'Correo Institucional';
                iconoIdentidad.className = 'fas fa-envelope input-icon';
                inputIdentidad = crearInput('email', 'email', 'usuario@utp.ac.pa', 'email');
            } else {
                labelIdentidad.textContent = 'Nombre de usuario';
                iconoIdentidad.className = 'fas fa-user input-icon';
                inputIdentidad = crearInput('text', 'username', 'Tu nombre de usuario', 'username');
            }
            inputIdentidadContainer.appendChild(inputIdentidad);

            if (errorCorreo) errorCorreo.textContent = '';
            inputIdentidad.style.borderColor = '#e2e8f0';
            inputIdentidad.value = '';
        }
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

    formulario.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'identidad') validarIdentidad();
    });
    formulario.addEventListener('blur', function(e) {
        if (e.target && e.target.id === 'identidad') validarIdentidad();
    }, true);

    formulario.addEventListener('submit', function(e) {
        e.preventDefault();

        if (estado === 'correo') {
            if (!validarIdentidad()) return;

            formulario.innerHTML = `
                <div class="form-group">
                    <label for="codigo">Código de verificación</label>
                    <div class="input-container">
                        <i class="fas fa-key input-icon"></i>
                        <input
                            type="number"
                            id="codigo"
                            name="codigo"
                            placeholder="Ingresa el código recibido"
                            required
                            autocomplete="off"
                        />
                    </div>
                </div>
                <button type="submit" class="login-button" id="verificarBtn">
                    <span class="button-text">Verificar código</span>
                    <i class="fas fa-arrow-right button-icon"></i>
                </button>
            `;
            estado = 'codigo';
        } else if (estado === 'codigo') {
            formulario.innerHTML = `
                <div class="form-group">
                    <label for="nuevaContrasena">Nueva contraseña</label>
                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="nuevaContrasena"
                            name="nuevaContrasena"
                            placeholder="Nueva contraseña"
                            required
                            autocomplete="new-password"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmarContrasena">Confirmar contraseña</label>
                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="confirmarContrasena"
                            name="confirmarContrasena"
                            placeholder="Confirma tu contraseña"
                            required
                            autocomplete="new-password"
                        />
                    </div>
                </div>
                <button type="submit" class="login-button" id="guardarBtn">
                    <span class="button-text">Guardar</span>
                    <i class="fas fa-check button-icon"></i>
                </button>
            `;
            estado = 'nuevaContrasena';
        } else if (estado === 'nuevaContrasena') {
            const nueva = document.getElementById('nuevaContrasena').value;
            const confirmar = document.getElementById('confirmarContrasena').value;
            if (nueva !== confirmar) {
                alert('Las contraseñas no coinciden');
                return;
            }
            // Mostrar modal de éxito
            const modal = document.getElementById('exitoModal');
            modal.style.display = 'flex';

            document.getElementById('closeExitoModal').onclick = function() {
                modal.style.display = 'none';
                window.location.href = "login.html";
            };
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    window.location.href = "login.html";
                }
            };
        }
    });
});