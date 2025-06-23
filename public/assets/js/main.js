document.addEventListener("DOMContentLoaded", function () {
    const productos = document.querySelectorAll('.card');
    productos.forEach(producto => {
        producto.addEventListener('mouseenter', () => {
            producto.classList.add('hover');
        });
        producto.addEventListener('mouseleave', () => {
            producto.classList.remove('hover');
        });
    });
});

// Función para el menú hamburguesa, donde al darle click se despliega el menú en toda la pantalla
document.addEventListener("DOMContentLoaded", () => {
    const hamburgerMenu = document.getElementById("hamburger-menu");
    const nav = document.getElementById("nav");
    const body = document.body;

    hamburgerMenu.addEventListener("click", () => {
        nav.classList.toggle("show"); 
        body.classList.toggle("menu-open"); 
    });

    // Cierra el menú al hacer clic en un enlace
    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(link => {
        link.addEventListener("click", () => {
            nav.classList.remove("show");
            body.classList.remove("menu-open");
        });
    });
});

// Función para el menú de usuario
document.addEventListener("DOMContentLoaded", () => {
    const userIcon = document.getElementById("user-icon");
    const userOptions = document.getElementById("user-options");

    
    userIcon.addEventListener("click", () => {
        userOptions.classList.toggle("show");
    });

  
    document.addEventListener("click", (event) => {
        if (!userIcon.contains(event.target) && !userOptions.contains(event.target)) {
            userOptions.classList.remove("show");
        }
    });
});

// Función para cargar las vistas
function cargarVista(archivo) {
        fetch(archivo)
          .then((r) => r.text())
          .then(
            (html) => (document.getElementById("main-content").innerHTML = html)
          );
      }
      window.onload = () => cargarVista("index.html");

      