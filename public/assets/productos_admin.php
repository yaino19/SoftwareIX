<?php
require_once(__DIR__ . '/../../config/config.php');
$conn = new mysqli($host, $username, $password, $database);

if (isset($_GET['action'])) {
  header('Content-Type: application/json');
  if ($_GET['action'] == 'agregar') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $imagen_url = '';

    // Procesar imagen si se subió
    if (!empty($_FILES['imagen']['name'])) {
        $target_dir = "img/merch/accesorios/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../public/assets/" . $target_file)) {
            $imagen_url = $target_file;
        }
    }

    // Si no hay imagen, se puede dejar vacío
    $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, categoria_id, imagen_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $nombre, $precio, $categoria_id, $imagen_url);
    $ok = $stmt->execute();
    echo json_encode(['success' => $ok]);
    exit;
  }
  if ($_GET['action'] == 'obtener') {
    // Devuelve datos de un producto
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM productos WHERE id=$id");
    echo json_encode($res->fetch_assoc());
    exit;
  }
  if ($_GET['action'] == 'editar') {
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $imagen_url = '';

    // Procesar imagen si se subió
    if (!empty($_FILES['imagen']['name'])) {
        $target_dir = "img/merch/accesorios/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../public/assets/" . $target_file)) {
            $imagen_url = $target_file;
        }
    }

    if ($imagen_url) {
        $stmt = $conn->prepare("UPDATE productos SET nombre=?, precio=?, categoria_id=?, imagen_url=? WHERE id=?");
        $stmt->bind_param("sdisi", $nombre, $precio, $categoria_id, $imagen_url, $id);
    } else {
        $stmt = $conn->prepare("UPDATE productos SET nombre=?, precio=?, categoria_id=? WHERE id=?");
        $stmt->bind_param("sdii", $nombre, $precio, $categoria_id, $id);
    }
    $ok = $stmt->execute();
    echo json_encode(['success' => $ok]);
    exit;
  }
  if ($_GET['action'] == 'eliminar') {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM productos WHERE id=$id");
    echo json_encode(['success' => true]);
    exit;
  }
}

// Consulta para obtener productos y categorías
$sql = "SELECT p.*, c.nombre AS categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);
    }
    .card-producto {
      box-shadow: 0 4px 24px rgba(123,91,132,0.10);
      border-radius: 18px;
      transition: box-shadow 0.2s;
      position: relative;
      overflow: hidden;
    }
    .card-producto:hover {
      box-shadow: 0 8px 32px rgba(123,91,132,0.18);
    }
    .card-img-top {
      height: 180px;
      object-fit: cover;
      border-radius: 18px 18px 0 0;
      background: #f3e8ff;
    }
    .btn-fab {
      position: absolute;
      top: 12px;
      right: 12px;
      z-index: 2;
      border-radius: 50%;
      padding: 0.5rem 0.6rem;
      font-size: 1.1rem;
    }
    .btn-fab-edit {
      right: 48px;
      background: #6366f1;
      color: #fff;
    }
    .btn-fab-delete {
      background: #ef4444;
      color: #fff;
    }
    .card-title {
      color: #7c3aed;
      font-weight: 700;
      font-size: 1.2rem;
    }
    .card-category {
      font-size: 0.95rem;
      color: #6366f1;
      font-weight: 500;
      margin-bottom: 0.5rem;
    }
    .card-price {
      font-size: 1.1rem;
      color: #111827;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    .add-btn {
      position: fixed;
      bottom: 32px;
      right: 32px;
      z-index: 100;
      border-radius: 50%;
      font-size: 1.6rem;
      padding: 0.8rem 1rem;
      background: #7c3aed;
      color: #fff;
      box-shadow: 0 4px 16px rgba(123,91,132,0.15);
    }
  </style>
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4 text-center fw-bold" style="color:#7c3aed;">Gestión de Productos</h2>
  <div class="card shadow-lg border-0 mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-primary">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Precio</th>
              <th scope="col">Categoría</th>
              <th scope="col">Imagen</th>
              <th scope="col" class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td class="fw-semibold" style="color:#7c3aed;"><?php echo htmlspecialchars($row['nombre']); ?></td>
              <td class="fw-bold">$<?php echo number_format($row['precio'], 2); ?></td>
              <td>
                <span class="badge rounded-pill bg-light text-primary px-3 py-2">
                  <?php echo htmlspecialchars($row['categoria_nombre'] ?? $row['categoria_id']); ?>
                </span>
              </td>
              <td>
              <img src="./public/assets/<?php echo htmlspecialchars($row['imagen_url']); ?>" alt="img" class="img-thumbnail" style="width:60px;height:60px;">
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-primary btn-edit me-1" data-id="<?php echo $row['id']; ?>" title="Editar">
                  <i class="fa fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="<?php echo $row['id']; ?>" title="Eliminar">
                  <i class="fa fa-trash"></i>
                </button>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Botón flotante para agregar -->
  <button class="btn btn-lg btn-primary rounded-circle shadow add-btn d-flex align-items-center justify-content-center"
          data-bs-toggle="modal" data-bs-target="#modalAgregar" title="Agregar Producto"
          style="position: fixed; bottom: 32px; right: 32px; z-index: 100;">
    <i class="fa fa-plus" style="font-size:1.7rem;"></i>
  </button>
</div>
<!-- Modal Agregar Producto -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formAgregar" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarLabel">Agregar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Campos del producto -->
        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>
        <input type="number" name="precio" class="form-control mb-2" placeholder="Precio" required>
        <select name="categoria_id" class="form-select mb-2" required>
          <option value="">Categoría</option>
          <option value="1">Accesorios</option>
          <option value="2">Ropa</option>
          <option value="3">Oficina</option>
        </select>
        <input type="file" name="imagen" class="form-control mb-2" accept="image/*">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Editar Producto (se rellena por JS) -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditar" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarLabel">Editar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="editarBody">
        <!-- Se rellena por JS -->
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('formAgregar').onsubmit = function(e) {
  e.preventDefault();
  let formData = new FormData(this);
  fetch('productos_admin.php?action=agregar', {
    method: 'POST',
    body: formData
  }).then(r => r.json()).then(data => {
    if(data.success) location.reload();
    else alert('Error al agregar');
  });
};

document.querySelectorAll('.btn-edit').forEach(btn => {
  btn.onclick = function() {
    let id = this.dataset.id;
    fetch('productos_admin.php?action=obtener&id=' + id)
      .then(r => r.json())
      .then(data => {
        document.getElementById('editarBody').innerHTML = `
          <input type="hidden" name="id" value="${data.id}">
          <input type="text" name="nombre" class="form-control mb-2" value="${data.nombre}" required>
          <input type="number" name="precio" class="form-control mb-2" value="${data.precio}" required>
          <select name="categoria_id" class="form-select mb-2" required>
            <option value="1" ${data.categoria_id==1?'selected':''}>Accesorios</option>
            <option value="2" ${data.categoria_id==2?'selected':''}>Ropa</option>
            <option value="3" ${data.categoria_id==3?'selected':''}>Oficina</option>
          </select>
          <input type="file" name="imagen" class="form-control mb-2" accept="image/*">
        `;
        new bootstrap.Modal(document.getElementById('modalEditar')).show();
      });
  };
});

document.getElementById('formEditar').onsubmit = function(e) {
  e.preventDefault();
  let formData = new FormData(this);
  fetch('productos_admin.php?action=editar', {
    method: 'POST',
    body: formData
  }).then(r => r.json()).then(data => {
    if(data.success) location.reload();
    else alert('Error al editar');
  });
};

// Eliminar producto
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.onclick = function() {
    if(confirm('¿Seguro que deseas eliminar este producto?')) {
      fetch('productos_admin.php?action=eliminar&id=' + this.dataset.id)
        .then (r => r.json())
        .then(data => {
          if(data.success) location.reload();
          else alert('Error al eliminar');
        });
    }
  };
});
</script>
</body>
</html>