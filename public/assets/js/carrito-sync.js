// Sistema de sincronización del carrito entre pestañas
class CarritoSync {
    constructor() {
        this.callbacks = [];
        this.ultimaActualizacion = 0;
        this.intervalo = null;
        this.init();
    }

    init() {
        // Escuchar eventos de storage
        window.addEventListener('storage', (e) => {
            if (e.key === 'carritoActualizado') {
                this.procesarCambio(e.newValue);
            }
        });

        // Escuchar eventos personalizados
        window.addEventListener('carrito-actualizado', (e) => {
            this.procesarCambio(e.detail.timestamp);
        });

        // Polling como respaldo
        this.iniciarPolling();

        // Limpiar al salir
        window.addEventListener('beforeunload', () => {
            this.limpiar();
        });
    }

    procesarCambio(timestamp) {
        const ts = parseInt(timestamp);
        if (ts > this.ultimaActualizacion) {
            this.ultimaActualizacion = ts;
            this.notificarCallbacks();
        }
    }

    notificarCallbacks() {
        this.callbacks.forEach(callback => {
            try {
                callback();
            } catch (error) {
                console.error('Error en callback de sincronización:', error);
            }
        });
    }

    agregarCallback(callback) {
        this.callbacks.push(callback);
    }

    notificarCambio() {
        const timestamp = Date.now();
        this.ultimaActualizacion = timestamp;
        
        // Notificar via localStorage
        localStorage.setItem('carritoActualizado', timestamp);
        
        // Notificar via evento personalizado
        window.dispatchEvent(new CustomEvent('carrito-actualizado', {
            detail: { timestamp }
        }));
        
        // También forzar en la misma ventana
        this.notificarCallbacks();
    }

    iniciarPolling() {
        this.intervalo = setInterval(() => {
            const timestamp = localStorage.getItem('carritoActualizado');
            if (timestamp) {
                this.procesarCambio(timestamp);
            }
        }, 1500); // Cada 1.5 segundos
    }

    limpiar() {
        if (this.intervalo) {
            clearInterval(this.intervalo);
        }
    }
}

// Sistema de mensajes únicos
class MensajeUnico {
    constructor() {
        this.mensajeActual = null;
    }

    mostrar(mensaje, tipo = 'success') {
        // Eliminar mensaje anterior si existe
        if (this.mensajeActual) {
            this.mensajeActual.remove();
            this.mensajeActual = null;
        }

        // Crear nuevo mensaje
        const toast = document.createElement('div');
        toast.className = `toast-notification ${tipo}`;
        toast.innerHTML = `
            <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${mensaje}</span>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(toast);
        this.mensajeActual = toast;
        
        // Mostrar con animación
        setTimeout(() => toast.classList.add('show'), 100);
        
        // Auto-eliminar después de 3 segundos
        setTimeout(() => {
            if (this.mensajeActual === toast) {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                    if (this.mensajeActual === toast) {
                        this.mensajeActual = null;
                    }
                }, 400);
            }
        }, 3000);
    }
}

// Instancias globales
window.carritoSync = new CarritoSync();
window.mensajeUnico = new MensajeUnico();
