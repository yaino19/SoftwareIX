document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('loginForm');
    let estado = 'correo';
    let correoRecuperacion = '';

    // Renderiza el input de correo
    function renderCorreo() {
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
                        placeholder="Tu correo institucional @utp.ac.pa"
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

    // Renderiza el input de código
    function renderCodigo() {
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
    }

    // Renderiza los inputs de nueva contraseña
    function renderNuevaContrasena() {
        formulario.innerHTML = `
            <div class="form-group">
                <label for="nuevaContrasena">Nueva contraseña</label>
                <div class="input-container" style="position:relative;">
                    <i class="fas fa-lock input-icon"></i>
                    <input
                        type="password"
                        id="nuevaContrasena"
                        name="nuevaContrasena"
                        placeholder="Nueva contraseña"
                        required
                        autocomplete="new-password"
                    />
                    <span class="toggle-password" id="toggleNuevaContrasena" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888; font-size:1.2em;"><i class="fas fa-eye-slash"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmarContrasena">Confirmar contraseña</label>
                <div class="input-container" style="position:relative;">
                    <i class="fas fa-lock input-icon"></i>
                    <input
                        type="password"
                        id="confirmarContrasena"
                        name="confirmarContrasena"
                        placeholder="Confirma tu contraseña"
                        required
                        autocomplete="new-password"
                    />
                    <span class="toggle-password" id="toggleConfirmarContrasena" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888; font-size:1.2em;"><i class="fas fa-eye-slash"></i></span>
                </div>
            </div>
            <button type="submit" class="login-button" id="guardarBtn">
                <span class="button-text">Guardar</span>
                <i class="fas fa-check button-icon"></i>
            </button>
        `;
        // Agregar funcionalidad de mostrar/ocultar contraseña
        setTimeout(() => {
            const nuevaInput = document.getElementById('nuevaContrasena');
            const confirmarInput = document.getElementById('confirmarContrasena');
            const toggleNueva = document.getElementById('toggleNuevaContrasena');
            const toggleConfirmar = document.getElementById('toggleConfirmarContrasena');
            if (toggleNueva && nuevaInput) {
                toggleNueva.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    const visible = nuevaInput.type === 'text';
                    nuevaInput.type = visible ? 'password' : 'text';
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
            if (toggleConfirmar && confirmarInput) {
                toggleConfirmar.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    const visible = confirmarInput.type === 'text';
                    confirmarInput.type = visible ? 'password' : 'text';
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
        }, 0);
    }

    // Inicializa el formulario
    renderCorreo();

    // Variables de elementos dinámicos
    let esEstudianteUTP, labelIdentidad, inputIdentidadContainer, iconoIdentidad, inputIdentidad, errorCorreo;

    function actualizarRefs() {
        esEstudianteUTP = document.getElementById('esEstudianteUTP');
        labelIdentidad = document.getElementById('labelIdentidad');
        inputIdentidadContainer = document.getElementById('inputIdentidadContainer');
        iconoIdentidad = document.getElementById('iconoIdentidad');
        inputIdentidad = document.getElementById('identidad');
        errorCorreo = document.getElementById('emailError');
    }

    // Crea un input dinámicamente
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

    // Validación de correo
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

    // Delegación de eventos para inputs dinámicos
    formulario.addEventListener('change', function(e) {
        actualizarRefs();
        if (e.target && e.target.id === 'esEstudianteUTP') {
            inputIdentidadContainer.removeChild(inputIdentidad);
            if (e.target.checked) {
                labelIdentidad.textContent = 'Correo Institucional';
                iconoIdentidad.className = 'fas fa-envelope input-icon';
                inputIdentidad = crearInput('email', 'email', 'Tu correo insitucional', 'email');
            } else {
                labelIdentidad.textContent = 'Correo electrónico';
                iconoIdentidad.className = 'fas fa-envelope input-icon';
                inputIdentidad = crearInput('email', 'email', 'Tu correo electronico', 'email');
            }
            inputIdentidadContainer.appendChild(inputIdentidad);
            if (errorCorreo) errorCorreo.textContent = '';
            inputIdentidad.style.borderColor = '#e2e8f0';
            inputIdentidad.value = '';
        }
    });

    formulario.addEventListener('input', function(e) {
        actualizarRefs();
        if (e.target && e.target.id === 'identidad') validarIdentidad();
    });
    formulario.addEventListener('blur', function(e) {
        actualizarRefs();
        if (e.target && e.target.id === 'identidad') validarIdentidad();
    }, true);

    formulario.addEventListener('submit', async function(e) {
        e.preventDefault();
        actualizarRefs();
        if (estado === 'correo') {
            if (!validarIdentidad()) return;
            correoRecuperacion = document.getElementById('identidad') ? document.getElementById('identidad').value : '';
            // Mostrar modal de carga mientras se solicita el código
            const loadingModal = document.getElementById('loadingModal');
            loadingModal.querySelector('h2').textContent = 'Enviando correo...';
            loadingModal.style.display = 'flex';
            let response = await fetch('recuperar_contra.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `correo=${encodeURIComponent(correoRecuperacion)}`
            });
            let data = await response.text();
            loadingModal.style.display = 'none';
            // Mostrar modal de mensaje
            mostrarMensajeModal(data);
            // Si el mensaje es de éxito, pasar al siguiente paso
            if (data.toLowerCase().includes('se ha enviado un correo')) {
                renderCodigo();
                estado = 'codigo';
            }
        } else if (estado === 'codigo') {
            // Mostrar modal de carga
            const loadingModal = document.getElementById('loadingModal');
            loadingModal.querySelector('h2').textContent = 'Verificando código...';
            loadingModal.style.display = 'flex';
            // Obtener correo y código
            const codigo = document.getElementById('codigo').value;
            // Validar código con backend
            let response = await fetch('recuperar_contra.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `verificar_codigo=1&correo=${encodeURIComponent(correoRecuperacion)}&codigo=${encodeURIComponent(codigo)}`
            });
            let data = await response.text();
            loadingModal.style.display = 'none';
            // Mostrar solo el modal de mensaje (sin alert)
            mostrarMensajeModal(data);
            if (data.includes('Código verificado')) {
                renderNuevaContrasena();
                estado = 'nuevaContrasena';
            }
        } else if (estado === 'nuevaContrasena') {
            const nueva = document.getElementById('nuevaContrasena').value;
            const confirmar = document.getElementById('confirmarContrasena').value;
            var regexMayuscula = /[A-Z]/;
            var regexSimbolo = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;
            if (nueva.length < 7) {
                mostrarMensajeModal('La contraseña debe tener al menos 7 caracteres.');
                return;
            }
            if (!regexMayuscula.test(nueva)) {
                mostrarMensajeModal('La contraseña debe contener al menos una letra mayúscula.');
                return;
            }
            if (!regexSimbolo.test(nueva)) {
                mostrarMensajeModal('La contraseña debe contener al menos un símbolo (por ejemplo: !, @, #, etc).');
                return;
            }
            if (nueva !== confirmar) {
                mostrarMensajeModal('Las contraseñas no coinciden');
                return;
            }
            // Mostrar modal de carga para cambio de contraseña
            const loadingModal = document.getElementById('loadingModal');
            loadingModal.querySelector('h2').textContent = 'Actualizando contraseña...';
            loadingModal.style.display = 'flex';
            // Enviar nueva contraseña al backend
            let response = await fetch('recuperar_contra.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `cambiar_contrasena=1&correo=${encodeURIComponent(correoRecuperacion)}&nuevaContrasena=${encodeURIComponent(nueva)}`
            });
            let data = await response.text();
            loadingModal.style.display = 'none';
            if (data.includes('Contraseña actualizada correctamente')) {
                const modal = document.getElementById('exitoModal');
                modal.style.display = 'flex';
                setTimeout(function() {
                    window.location.href = "/SoftwareIX/public/assets/login.php";
                }, 2000);
                document.getElementById('closeExitoModal').onclick = function() {
                    modal.style.display = 'none';
                    window.location.href = "/SoftwareIX/public/assets/login.php";
                };
                window.onclick = function(event) {
                    if (event.target === modal) {
                        modal.style.display = 'none';
                        window.location.href = "/SoftwareIX/public/assets/login.php";
                    }
                };
            } else {
                mostrarMensajeModal(data);
            }
        }
    });

    // Función para mostrar el modal de mensaje
    function mostrarMensajeModal(mensaje) {
        const modal = document.getElementById('mensajeModal');
        const icon = document.getElementById('mensajeModalIcon');
        const titulo = document.getElementById('mensajeModalTitulo');
        const texto = document.getElementById('mensajeModalTexto');
        // Determinar tipo de mensaje
        let esExito = mensaje.toLowerCase().includes('se ha enviado un correo');
        let esNoExiste = mensaje.toLowerCase().includes('no está registrado') || mensaje.toLowerCase().includes('no existe') || mensaje.toLowerCase().includes('no se encuentra');
        let esErrorEnvio = mensaje.toLowerCase().includes('no se pudo enviar');
        if (esExito) {
            icon.innerHTML = '<i class="fas fa-envelope-circle-check" style="color:#22c55e;"></i>';
            titulo.textContent = '¡Correo enviado!';
        } else if (esNoExiste) {
            icon.innerHTML = '<i class="fas fa-exclamation-circle" style="color:#ef4444;"></i>';
            titulo.textContent = 'Correo no encontrado';
        } else if (esErrorEnvio) {
            icon.innerHTML = '<i class="fas fa-times-circle" style="color:#ef4444;"></i>';
            titulo.textContent = 'Error al enviar';
        } else {
            icon.innerHTML = '<i class="fas fa-info-circle" style="color:#f59e42;"></i>';
            titulo.textContent = 'Aviso';
        }
        texto.textContent = mensaje;
        modal.style.display = 'flex';
        document.getElementById('closeMensajeModal').onclick = function() {
            modal.style.display = 'none';
        };
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    }

    // Inicializa referencias al cargar
    actualizarRefs();
});