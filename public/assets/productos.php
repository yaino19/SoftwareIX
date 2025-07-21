<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once(__DIR__ . '/../../config/config.php');
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$categoria = isset($_GET['categoria']) && $_GET['categoria'] !== '' ? intval($_GET['categoria']) : null;
$sql = "SELECT * FROM productos";
if ($categoria) {
    $sql .= " WHERE categoria_id = $categoria";
}
$result = $conn->query($sql);


// Si es AJAX, solo devuelve las cards
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    while($row = $result->fetch_assoc()): ?>
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="./public/assets/<?php echo htmlspecialchars($row['imagen_url']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" />
          <div class="card-body p-4">
            <div class="text-center">
              <h5 class="fw-bolder"><?php echo htmlspecialchars($row['nombre']); ?></h5>
              $<?php echo number_format($row['precio'], 2); ?>
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
          </div>
        </div>
      </div>
    <?php endwhile;
    exit;
}
?>
<div class="productos-section" style="padding:32px 0 0 0; background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%); min-height:60vh;">
  <div class="container">
    <h3 class="section-title" style="margin-top:0;">Todos los Productos</h3>
    <section class="py-5">
      <div class="container px-4 px-lg-5 mt-4">
        <div class="container my-2">
          <div class="d-flex align-items-center gap-3 filtro-bar" style="background: #f3e8ff; border-radius: 18px; padding: 0.7rem 1.2rem;">
            <span style="color: #7c3aed; font-weight: 600; letter-spacing: 1px;">
              Filtra los productos por categoría:
            </span>
            <form method="get" class="mb-0" onsubmit="return false;">
              <select name="categoria" id="categoria" class="btn btn-filtro" style="margin-left: 8px;">
                <option value="">Todas</option>
                <option value="1" <?php if(isset($_GET['categoria']) && $_GET['categoria']=='1') echo 'selected'; ?>>Accesorios</option>
                <option value="2" <?php if(isset($_GET['categoria']) && $_GET['categoria']=='2') echo 'selected'; ?>>Ropa</option>
                <option value="3" <?php if(isset($_GET['categoria']) && $_GET['categoria']=='3') echo 'selected'; ?>>Oficina</option>
              </select>
            </form>
          </div>
        </div>
        <div id="productos-list" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
          <?php while($row = $result->fetch_assoc()): ?>
            <div class="col mb-5">
              <div class="card h-100">
                <img class="card-img-top" src="./public/assets/<?php echo htmlspecialchars($row['imagen_url']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" />
                <div class="card-body p-4">
                  <div class="text-center">
                    <h5 class="fw-bolder"><?php echo htmlspecialchars($row['nombre']); ?></h5>
                    $<?php echo number_format($row['precio'], 2); ?>
                  </div>
                </div>
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                  <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Agregar al carrito</a></div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </section>
  </div>
</div>
<style>
.productos-list { margin-top:32px; }
.producto-item:hover { box-shadow:0 8px 32px rgba(123,91,132,0.18); }
</style>
<script>
document.getElementById('categoria').addEventListener('change', function() {
    var categoria = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', './public/assets/productos.php?categoria=' + encodeURIComponent(categoria) + '&ajax=1', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('productos-list').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>