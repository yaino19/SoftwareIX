<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <style>
  </style>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>ZonaUTP</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../assets/css/style-clothes.css" rel="stylesheet" />
        <link href="../assets/css/style.css" rel="stylesheet" /> <!-- Agrega esto después -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    </head>
    <body>
       <header class="header">
      <div class="container header-container">
        <div class="logo-container">
          <img src="./img/LogoPrincipal.png" alt="Logo" class="logo"/>
          <h1 class="site-title">zona-UTP</h1>
        </div>

        <div class="search-container">
          <input
            type="text"
            class="search-input"
            placeholder="Buscar productos..."
          />
          <button class="search-button">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <button class="hamburger-menu" id="hamburger-menu">
          <i class="fas fa-bars"></i>
        </button>
        <nav class="nav" id="nav">
          <ul class="nav-list">
            <li class="nav-item">
              <a class="nav-link" href="../../index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="productos.html">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contacto.html">Contacto</a>
            </li>
          </ul>
        </nav>
        <div class="user-menu">
          <i class="fas fa-user-circle" id="user-icon"></i>
          <div class="user-options" id="user-options">
              <a href="perfil.html" class="user-option">
                <i class="fas fa-user"></i> Perfil
              </a>
              <a href="carrito.html" class="user-option">
                <i class="fas fa-shopping-cart"></i> Carrito
              </a>
              <a href="#" class="user-option-logout" id="logout-link">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
              </a>
              <a href="login.php" class="user-option">
                <i class="fas fa-user"></i> Iniciar sesión
              </a>
          </div>
        </div>
      </div>
    </header>

    <section class="banner">
        <div class="container banner-container">
          <h2 class="banner-title">¡Hey, bienvenido a Zona-UTP!</h2>
          <p class="banner-text">
            Más que solo merch, aquí encuentras estilo universitario con
            actitud. ¿Listo para llevar tu orgullo UTP al siguiente nivel? 🚀
          </p>
        </div>
      </section>


<br>
    <!-- Botón de filtro -->
    <div class="container my-2">
  <div class="d-flex align-items-center gap-3 filtro-bar" style="background: #f3e8ff; border-radius: 18px; padding: 0.7rem 1.2rem;">
    <span style="color: #7c3aed; font-weight: 600; letter-spacing: 1px;">
      Filtra los productos por categoría, precio o tipo:
    </span>
    <button class="btn btn-filtro" id="filtro-btn">
      <i class="fas fa-filter"></i> Filtro
    </button>
  </div>
</div>
        <!-- Section-->
        <section class="py-5">
  <div class="container px-4 px-lg-5 mt-4">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

      <!-- ACCESORIOS -->
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/bolsa_blanca.png" alt="Bolsa Blanca" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Bolsa Blanca</h5>
              $8.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/bolsa_sencilla.png" alt="Bolsa Sencilla" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Bolsa Sencilla</h5>
              $6.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/bolsa1.png" alt="Bolsa 1" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Bolsa 1</h5>
              $7.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/bolsa2.png" alt="Bolsa 2" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Bolsa 2</h5>
              $7.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/llavero_blanco.png" alt="Llavero Blanco" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Llavero Blanco</h5>
              $4.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/llavero.png" alt="Llavero" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Llavero</h5>
              $4.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/llavero2.png" alt="Llavero 2" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Llavero 2</h5>
              $4.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/llavero3.png" alt="Llavero 3" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Llavero 3</h5>
              $4.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/llavero4.png" alt="Llavero 4" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Llavero 4</h5>
              $4.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/Portacredenciales_2.png" alt="Portacredenciales 2" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Portacredenciales 2</h5>
              $5.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/Portacredenciales.png" alt="Portacredenciales" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Portacredenciales</h5>
              $5.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/Pulsera Deportiva.png" alt="Pulsera Deportiva" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Pulsera Deportiva</h5>
              $3.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/pulsera_2.png" alt="Pulsera 2" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Pulsera 2</h5>
              $3.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/taza.png" alt="Taza" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Taza</h5>
              $6.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/termo_verde.png" alt="Termo Verde" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Termo Verde</h5>
              $10.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/termo.png" alt="Termo" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Termo</h5>
              $10.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/termo1.png" alt="Termo 1" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Termo 1</h5>
              $10.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/termo2.png" alt="Termo 2" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Termo 2</h5>
              $10.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/termo3.png" alt="Termo 3" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Termo 3</h5>
              $10.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/termo4.png" alt="Termo 4" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Termo 4</h5>
              $10.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/accesorios/termoblanco.png" alt="Termo Blanco" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Termo Blanco</h5>
              $10.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>

      <!-- ROPA -->
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/ropa/chaqueta.png" alt="Chaqueta UTP" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Chaqueta UTP</h5>
              $45.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/ropa/chaqueta_mujer.png" alt="Chaqueta Mujer UTP" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Chaqueta Mujer UTP</h5>
              $48.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/ropa/sueter.png" alt="Suéter UTP" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Suéter UTP</h5>
              $35.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/ropa/sueter2.png" alt="Suéter Estampado" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Suéter Estampado</h5>
              $38.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/ropa/jacket_negro.png" alt="Jacket Negro UTP" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Jacket Negro UTP</h5>
              $50.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/ropa/gorra3.png" alt="Gorra Logo UTP" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Gorra Logo UTP</h5>
              $15.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/ropa/gorra2.png" alt="Gorra Estampada" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Gorra Estampada</h5>
              $16.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>

      <!-- OFICINA -->
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/oficina/Cubiculo.png" alt="Cubiculo" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Cubiculo</h5>
              $12.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="./img/merch/oficina/cuadernos.png" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Conjunto de Cuadernos</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    <span class="text-muted text-decoration-line-through">$20.00</span>
                                    $18.00
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
                            </div>
                        </div>
                    </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/oficina/Folder.png" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Folder</h5>
              $3.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/oficina/cuaderno.png" alt="Agenda UTP" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Agenda UTP</h5>
              $18.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./img/merch/oficina/portadocumentos.png" alt="Portapapeles Estampado" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder">Portapapeles Estampado</h5>
              $8.00
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>

                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>