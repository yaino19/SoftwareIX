<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once(__DIR__ . '/../../config/config.php');
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Cargar categorías dinámicamente
$categorias = [];
$catResult = $conn->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC");
while ($cat = $catResult->fetch_assoc()) {
    $categorias[] = $cat;
}

$categoria = isset($_GET['categoria']) && $_GET['categoria'] !== '' ? intval($_GET['categoria']) : null;
$buscar = isset($_GET['buscar']) && $_GET['buscar'] !== '' ? trim($_GET['buscar']) : '';
$precio = isset($_GET['precio']) && $_GET['precio'] !== '' ? $_GET['precio'] : '';
$orden = isset($_GET['orden']) && $_GET['orden'] !== '' ? $_GET['orden'] : '';

$sql = "SELECT * FROM productos WHERE COALESCE(activo, 1) = 1";
$params = [];

if ($categoria) {
    $sql .= " AND categoria_id = ?";
    $params[] = $categoria;
}

if ($buscar) {
    $sql .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
    $params[] = "%$buscar%";
    $params[] = "%$buscar%";
}

if ($precio) {
    switch($precio) {
        case '0-10':
            $sql .= " AND precio BETWEEN 0 AND 10";
            break;
        case '10-20':
            $sql .= " AND precio BETWEEN 10 AND 20";
            break;
        case '20-50':
            $sql .= " AND precio BETWEEN 20 AND 50";
            break;
        case '50+':
            $sql .= " AND precio > 50";
            break;
    }
}

if ($orden) {
    switch($orden) {
        case 'nombre-asc':
            $sql .= " ORDER BY nombre ASC";
            break;
        case 'nombre-desc':
            $sql .= " ORDER BY nombre DESC";
            break;
        case 'precio-asc':
            $sql .= " ORDER BY precio ASC";
            break;
        case 'precio-desc':
            $sql .= " ORDER BY precio DESC";
            break;
        default:
            $sql .= " ORDER BY id DESC";
    }
} else {
    $sql .= " ORDER BY id DESC";
}

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

// Si es AJAX, solo devuelve las cards
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    while($row = $result->fetch_assoc()): ?>
      <div class="producto-card-wrapper">
        <div class="producto-card-enhanced">
          <div class="producto-image-container">
            <img class="producto-img-enhanced" src="./public/assets/<?php echo htmlspecialchars($row['imagen_url']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" />
          </div>
          <div class="producto-info">
            <h5 class="producto-title-enhanced"><?php echo htmlspecialchars($row['nombre']); ?></h5>
            <p class="producto-description-enhanced"><?php echo htmlspecialchars($row['descripcion'] ?? 'Producto de calidad premium'); ?></p>
            <div class="producto-price-enhanced">$<?php echo number_format($row['precio'], 2); ?></div>
            <button class="producto-button-enhanced">
              <i class="fas fa-shopping-cart"></i>
              Agregar al carrito
            </button>
          </div>
        </div>
      </div>
    <?php endwhile;
    exit;
}
?>
<div class="productos-section">
  <div class="container">
    <div class="productos-header">
      <h2 class="section-title">
        <i class="fas fa-shopping-bag"></i>
        Nuestros Productos
      </h2>
      <p class="productos-subtitle">Descubre nuestra colección exclusiva</p>
    </div>
    
    <!-- Filtros mejorados -->
    <div class="filtros-container">
      <div class="filtro-wrapper">
        <!-- Búsqueda -->
        <div class="filtro-grupo">
          <div class="filtro-label">
            <i class="fas fa-search"></i>
            <span>Buscar:</span>
          </div>
          <div class="filtro-input-wrapper">
            <input type="text" id="buscar-producto" class="filtro-input" placeholder="Nombre del producto...">
            <i class="fas fa-times filtro-clear" id="clear-search" style="display: none;"></i>
          </div>
        </div>

        <!-- Categoría -->
        <div class="filtro-grupo">
          <div class="filtro-label">
            <i class="fas fa-filter"></i>
            <span>Categoría:</span>
          </div>
          <div class="filtro-select-wrapper">
            <select name="categoria" id="categoria" class="filtro-select">
              <option value="">Todas las categorías</option>
              <?php foreach($categorias as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php if(isset($_GET['categoria']) && $_GET['categoria']==$cat['id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['nombre']); ?></option>
              <?php endforeach; ?>
            </select>
            <i class="fas fa-chevron-down filtro-icon"></i>
          </div>
        </div>

        <!-- Precio -->
        <div class="filtro-grupo">
          <div class="filtro-label">
            <i class="fas fa-dollar-sign"></i>
            <span>Precio:</span>
          </div>
          <div class="filtro-select-wrapper">
            <select id="filtro-precio" class="filtro-select">
              <option value="">Todos los precios</option>
              <option value="0-10">$0 - $10</option>
              <option value="10-20">$10 - $20</option>
              <option value="20-50">$20 - $50</option>
              <option value="50+">$50+</option>
            </select>
            <i class="fas fa-chevron-down filtro-icon"></i>
          </div>
        </div>

        <!-- Orden -->
        <div class="filtro-grupo">
          <div class="filtro-label">
            <i class="fas fa-sort"></i>
            <span>Ordenar:</span>
          </div>
          <div class="filtro-select-wrapper">
            <select id="filtro-orden" class="filtro-select">
              <option value="">Por defecto</option>
              <option value="nombre-asc">Nombre A-Z</option>
              <option value="nombre-desc">Nombre Z-A</option>
              <option value="precio-asc">Precio: menor a mayor</option>
              <option value="precio-desc">Precio: mayor a menor</option>
            </select>
            <i class="fas fa-chevron-down filtro-icon"></i>
          </div>
        </div>

        <!-- Botón limpiar -->
        <div class="filtro-grupo">
          <button class="btn-limpiar" onclick="limpiarFiltros()">
            <i class="fas fa-eraser"></i>
            <span>Limpiar</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Grid de productos mejorado -->
    <div class="productos-grid-container">
      <div id="productos-list" class="productos-grid">
          <?php while($row = $result->fetch_assoc()): ?>
            <div class="producto-card-wrapper">
              <div class="producto-card-enhanced">
                <div class="producto-image-container">
                  <img class="producto-img-enhanced" src="./public/assets/<?php echo htmlspecialchars($row['imagen_url']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" />
                </div>
                <div class="producto-info">
                  <h5 class="producto-title-enhanced"><?php echo htmlspecialchars($row['nombre']); ?></h5>
                  <p class="producto-description-enhanced"><?php echo htmlspecialchars($row['descripcion'] ?? 'Producto de calidad premium'); ?></p>
                  <div class="producto-price-enhanced">$<?php echo number_format($row['precio'], 2); ?></div>
                  <button class="producto-button-enhanced">
                    <i class="fas fa-shopping-cart"></i>
                    Agregar al carrito
                  </button>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  /* === ESTILOS MEJORADOS PARA PRODUCTOS === */
  .productos-section {
      padding: 80px 0;
      background: 
          radial-gradient(ellipse at top, #f8f9fa 0%, #e9ecef 30%, #dfe4ea 70%, #c8d6e5 100%),
          linear-gradient(135deg, rgba(123, 91, 132, 0.05) 0%, transparent 50%, rgba(175, 165, 95, 0.03) 100%);
      min-height: 80vh;
      position: relative;
      overflow: hidden;
  }

  .productos-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, #7b5b84, #100418, #6a3977, #afa55f);
      box-shadow: 0 2px 10px rgba(123, 91, 132, 0.3);
      z-index: 3;
  }

  .productos-section::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
          radial-gradient(circle at 20% 30%, rgba(123, 91, 132, 0.08) 0%, transparent 40%),
          radial-gradient(circle at 80% 70%, rgba(175, 165, 95, 0.06) 0%, transparent 40%),
          radial-gradient(circle at 40% 80%, rgba(106, 57, 119, 0.04) 0%, transparent 50%),
          repeating-linear-gradient(
              45deg,
              transparent,
              transparent 100px,
              rgba(255, 255, 255, 0.02) 100px,
              rgba(255, 255, 255, 0.02) 102px,
              transparent 102px,
              transparent 200px
          );
      pointer-events: none;
      z-index: 1;
  }

  /* Header de productos */
  .productos-header {
      text-align: center;
      margin-bottom: 60px;
      position: relative;
      z-index: 2;
      background: 
          linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9)),
          radial-gradient(circle at top right, rgba(123, 91, 132, 0.05), transparent);
      backdrop-filter: blur(15px);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 
          0 10px 40px rgba(123, 91, 132, 0.15),
          0 1px 0 rgba(255, 255, 255, 0.8) inset;
      border: 1px solid rgba(255, 255, 255, 0.3);
      position: relative;
      overflow: hidden;
  }

  .productos-header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: 
          conic-gradient(from 0deg at 50% 50%, 
              transparent 0deg, 
              rgba(123, 91, 132, 0.02) 90deg, 
              transparent 180deg, 
              rgba(175, 165, 95, 0.02) 270deg, 
              transparent 360deg);
      animation: rotate 20s linear infinite;
      z-index: -1;
  }

  @keyframes rotate {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
  }

  .productos-header .section-title {
      font-size: 2.5em;
      font-weight: 700;
      color: #100418;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
  }

  .productos-header .section-title i {
      color: #7b5b84;
      font-size: 0.8em;
  }

  .productos-subtitle {
      font-size: 1.1em;
      color: #666;
      font-weight: 400;
      margin: 0;
      font-style: italic;
  }

  /* Filtros mejorados */
  .filtros-container {
      margin-bottom: 40px;
      display: flex;
      justify-content: center;
  }

  .filtro-wrapper {
      background: 
          linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 249, 250, 0.95)),
          radial-gradient(circle at bottom left, rgba(123, 91, 132, 0.03), transparent);
      backdrop-filter: blur(20px);
      padding: 25px 35px;
      border-radius: 20px;
      box-shadow: 
          0 15px 50px rgba(123, 91, 132, 0.15),
          0 1px 0 rgba(255, 255, 255, 0.9) inset,
          0 0 0 1px rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      gap: 35px;
      border: 1px solid rgba(255, 255, 255, 0.4);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      z-index: 2;
      flex-wrap: wrap;
      justify-content: center;
      overflow: hidden;
  }

  .filtro-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 200%;
      height: 100%;
      background: 
          linear-gradient(90deg, 
              transparent, 
              rgba(255, 255, 255, 0.1) 25%, 
              rgba(123, 91, 132, 0.05) 50%, 
              rgba(255, 255, 255, 0.1) 75%, 
              transparent);
      transition: left 0.6s ease;
      z-index: 1;
  }

  .filtro-grupo {
      display: flex;
      flex-direction: column;
      gap: 8px;
      min-width: 180px;
      flex: 1;
      position: relative;
  }

  .filtro-grupo:not(:last-child)::after {
      content: '';
      position: absolute;
      right: -17px;
      top: 20%;
      bottom: 20%;
      width: 1px;
      background: linear-gradient(to bottom, transparent, rgba(123, 91, 132, 0.2), transparent);
  }

  .filtro-input-wrapper {
      position: relative;
      min-width: 220px;
  }

  .filtro-input {
      appearance: none;
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      border: 2px solid #ddd;
      border-radius: 10px;
      padding: 12px 40px 12px 15px;
      font-size: 1em;
      font-weight: 500;
      color: #333;
      transition: all 0.3s ease;
      width: 100%;
      outline: none;
  }

  .filtro-input:hover, .filtro-input:focus {
      border-color: #7b5b84;
      background: white;
      box-shadow: 0 0 0 3px rgba(123, 91, 132, 0.1);
  }

  .filtro-clear {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
      cursor: pointer;
      transition: color 0.3s ease;
      font-size: 0.9em;
  }

  .filtro-clear:hover {
      color: #dc3545;
  }

  .btn-limpiar {
      background: linear-gradient(135deg, #6c757d, #5a6268);
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      margin-top: 20px;
  }

  .btn-limpiar:hover {
      background: linear-gradient(135deg, #5a6268, #495057);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
  }

  .filtro-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 200%;
      height: 100%;
      background: 
          linear-gradient(90deg, 
              transparent, 
              rgba(255, 255, 255, 0.1) 25%, 
              rgba(123, 91, 132, 0.05) 50%, 
              rgba(255, 255, 255, 0.1) 75%, 
              transparent);
      transition: left 0.6s ease;
      z-index: 1;
  }

  .filtro-wrapper:hover::before {
      left: 100%;
  }

  .filtro-wrapper:hover {
      border-color: rgba(123, 91, 132, 0.3);
      transform: translateY(-2px);
      box-shadow: 
          0 20px 60px rgba(123, 91, 132, 0.2),
          0 1px 0 rgba(255, 255, 255, 1) inset,
          0 0 0 1px rgba(123, 91, 132, 0.1);
  }

  .filtro-label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      color: #100418;
      font-size: 0.95em;
      margin-bottom: 2px;
  }

  .filtro-label i {
      color: #7b5b84;
      font-size: 1.2em;
  }

  .filtro-select-wrapper {
      position: relative;
      min-width: 180px;
  }

  .filtro-select {
      appearance: none;
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      border: 2px solid #ddd;
      border-radius: 10px;
      padding: 12px 40px 12px 15px;
      font-size: 1em;
      font-weight: 500;
      color: #333;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
      outline: none;
  }

  .filtro-select:hover, .filtro-select:focus {
      border-color: #7b5b84;
      background: white;
      box-shadow: 0 0 0 3px rgba(123, 91, 132, 0.1);
  }

  .filtro-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #7b5b84;
      pointer-events: none;
      transition: transform 0.3s ease;
  }

  .filtro-select:focus + .filtro-icon {
      transform: translateY(-50%) rotate(180deg);
  }

  /* Grid de productos */
  .productos-grid-container {
      position: relative;
  }

  .productos-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 32px 24px;
      padding: 20px 0;
      align-items: stretch;
  }

  /* --- FIX: Fuerza el grid vertical y centra las cartas en la vista principal de productos, sin afectar el carrusel ni otros grids. --- */
  #productos-list.productos-grid {
      display: grid !important;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)) !important;
      gap: 32px 24px !important;
      width: 100% !important;
      margin: 0 auto !important;
      animation: none !important;
      justify-content: center !important;
      align-items: stretch !important;
  }
  @media (max-width: 768px) {
      #productos-list.productos-grid {
          grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)) !important;
          gap: 20px !important;
          padding: 0 10px !important;
      }
  }
  @media (max-width: 480px) {
      #productos-list.productos-grid {
          grid-template-columns: 1fr !important;
          gap: 20px !important;
          padding: 0 5px !important;
      }
  }

  /* Cards de productos mejoradas */
  .producto-card-wrapper {
      position: relative;
  }

  .producto-card-enhanced {
      background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
      backdrop-filter: blur(20px);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 
          0 15px 60px rgba(123, 91, 132, 0.12),
          0 5px 20px rgba(123, 91, 132, 0.08),
          inset 0 1px 0 rgba(255, 255, 255, 0.8);
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      border: 1px solid rgba(255, 255, 255, 0.5);
      position: relative;
      display: flex;
      flex-direction: column;
  }

  .producto-card-enhanced::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
          radial-gradient(circle at 20% 20%, rgba(123, 91, 132, 0.08) 0%, transparent 50%),
          radial-gradient(circle at 80% 80%, rgba(175, 165, 95, 0.06) 0%, transparent 50%),
          linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(248, 249, 250, 0.05));
      opacity: 0;
      transition: opacity 0.3s ease;
      border-radius: 20px;
      z-index: 1;
  }

  .producto-card-enhanced::after {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      background: linear-gradient(45deg, 
          rgba(123, 91, 132, 0.3),
          rgba(175, 165, 95, 0.2),
          rgba(123, 91, 132, 0.3));
      border-radius: 22px;
      z-index: -1;
      opacity: 0;
      transition: opacity 0.3s ease;
  }

  .producto-card-enhanced:hover::before {
      opacity: 1;
  }

  .producto-card-enhanced:hover::after {
      opacity: 1;
  }

  .producto-card-enhanced > * {
      position: relative;
      z-index: 2;
  }

  .producto-card-enhanced:hover {
      transform: translateY(-12px) scale(1.03);
      box-shadow: 
          0 25px 80px rgba(123, 91, 132, 0.25),
          0 10px 40px rgba(123, 91, 132, 0.15),
          inset 0 1px 0 rgba(255, 255, 255, 0.9);
      border-color: rgba(123, 91, 132, 0.3);
      background: linear-gradient(145deg, rgba(255, 255, 255, 0.98), rgba(248, 249, 250, 0.95));
  }

  .producto-image-container {
      position: relative;
      overflow: hidden;
      height: 160px;
      background: 
          linear-gradient(135deg, #f8f9fa, #e9ecef),
          radial-gradient(circle at 30% 30%, rgba(123, 91, 132, 0.08), transparent),
          radial-gradient(circle at 70% 70%, rgba(175, 165, 95, 0.06), transparent);
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .producto-image-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, 
          transparent 25%, 
          rgba(255, 255, 255, 0.1) 25%, 
          rgba(255, 255, 255, 0.1) 50%, 
          transparent 50%, 
          transparent 75%, 
          rgba(255, 255, 255, 0.1) 75%);
      background-size: 20px 20px;
      opacity: 0.3;
      z-index: 1;
  }

  .producto-img-enhanced {
      width: auto;
      height: 100%;
      max-width: 100%;
      object-fit: contain;
      display: block;
      margin: 0 auto;
      transition: transform 0.4s ease;
  }

  .producto-card-enhanced:hover .producto-img-enhanced {
      transform: scale(1.1);
  }

  /* Información del producto */
  .producto-info {
      padding: 20px 18px 18px 18px;
      text-align: left;
      flex: 1;
      background: 
          linear-gradient(to bottom, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9)),
          radial-gradient(circle at bottom right, rgba(123, 91, 132, 0.03), transparent);
      position: relative;
  }

  .producto-info::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, 
          transparent, 
          rgba(123, 91, 132, 0.2) 20%, 
          rgba(175, 165, 95, 0.15) 50%, 
          rgba(123, 91, 132, 0.2) 80%, 
          transparent);
      z-index: 1;
  }

  .producto-title-enhanced {
      font-size: 1.1em;
      font-weight: 600;
      color: #100418;
      margin-bottom: 6px;
      line-height: 1.2;
  }

  .producto-description-enhanced {
      font-size: 0.95em;
      color: #666;
      margin-bottom: 10px;
      line-height: 1.4;
      height: 38px;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
  }

  .producto-price-enhanced {
      font-size: 1.2em;
      font-weight: 700;
      color: #7b5b84;
      margin-bottom: 12px;
  }

  .producto-button-enhanced {
      background: linear-gradient(135deg, #7b5b84, #6a3977, #554e2a);
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.95em;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      box-shadow: 
          0 4px 15px rgba(123, 91, 132, 0.3),
          inset 0 1px 0 rgba(255, 255, 255, 0.2);
      position: relative;
      overflow: hidden;
  }

  .producto-button-enhanced::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, 
          transparent, 
          rgba(255, 255, 255, 0.2), 
          transparent);
      transition: left 0.5s ease;
  }

  .producto-button-enhanced:hover::before {
      left: 100%;
  }

  .producto-button-enhanced:hover {
      background: linear-gradient(135deg, #6a3977, #554e2a, #7b5b84);
      transform: translateY(-2px);
      box-shadow: 
          0 6px 20px rgba(123, 91, 132, 0.4),
          inset 0 1px 0 rgba(255, 255, 255, 0.3);
  }

  .producto-button-enhanced i {
      font-size: 1em;
  }

  /* Animación de carga */
  .productos-grid {
      animation: fadeInUp 0.6s ease-out;
  }

  @keyframes fadeInUp {
      from {
          opacity: 0;
          transform: translateY(30px);
      }
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }

  /* Responsive mejorado */
  @media (max-width: 768px) {
      .productos-section {
          padding: 40px 0;
      }
      
      .productos-header .section-title {
          font-size: 2em;
          flex-direction: column;
          gap: 10px;
      }
      
      .filtro-wrapper {
          flex-direction: column;
          gap: 25px;
          padding: 20px;
          align-items: stretch;
      }

      .filtro-grupo {
          min-width: auto;
          flex: none;
      }

      .filtro-grupo:not(:last-child)::after {
          display: none;
      }

      .filtro-input-wrapper {
          min-width: auto;
      }

      .btn-limpiar {
          margin-top: 10px;
          align-self: center;
          min-width: 150px;
      }
      
      .filtro-select-wrapper {
          min-width: auto;
      }
      
      .productos-grid {
          grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
          gap: 20px;
      }
      
      .producto-info {
          padding: 20px;
      }
  }

  @media (max-width: 480px) {
      .productos-grid {
          grid-template-columns: 1fr;
          gap: 20px;
      }
      
      .producto-card-enhanced:hover {
          transform: translateY(-4px) scale(1.01);
      }
  }

  /* Loading state */
  .productos-grid.loading {
      opacity: 0.6;
      pointer-events: none;
      background: none !important; /* Elimina fondo azul */
  }

  .productos-grid.loading::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 40px;
      height: 40px;
      border: 3px solid #f3f3f3;
      border-top: 3px solid #7b5b84;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      transform: translate(-50%, -50%);
      background: none !important;
  }

  @keyframes spin {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translate(-50%, -50%) rotate(360deg); }
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const categoriaSelect = document.getElementById('categoria');
      const productosGrid = document.getElementById('productos-list');
      
      // Agregar icono de Font Awesome si no está presente
      if (!document.querySelector('link[href*="font-awesome"]')) {
          const link = document.createElement('link');
          link.rel = 'stylesheet';
          link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
          document.head.appendChild(link);
      }

      categoriaSelect.addEventListener('change', function() {
          aplicarFiltros();
      });

      // Event listeners para los filtros
      document.getElementById('buscar-producto').addEventListener('input', function() {
          const clearBtn = document.getElementById('clear-search');
          if (this.value) {
              clearBtn.style.display = 'block';
          } else {
              clearBtn.style.display = 'none';
          }
          aplicarFiltros();
      });

      document.getElementById('clear-search').addEventListener('click', function() {
          document.getElementById('buscar-producto').value = '';
          this.style.display = 'none';
          aplicarFiltros();
      });

      document.getElementById('filtro-precio').addEventListener('change', aplicarFiltros);
      document.getElementById('filtro-orden').addEventListener('change', aplicarFiltros);

      function aplicarFiltros() {
          const categoria = categoriaSelect.value;
          const buscar = document.getElementById('buscar-producto').value;
          const precio = document.getElementById('filtro-precio').value;
          const orden = document.getElementById('filtro-orden').value;
          
          // Actualizar la URL sin recargar
          const url = new URL(window.location);
          if (categoria) url.searchParams.set('categoria', categoria);
          else url.searchParams.delete('categoria');
          if (buscar) url.searchParams.set('buscar', buscar);
          else url.searchParams.delete('buscar');
          if (precio) url.searchParams.set('precio', precio);
          else url.searchParams.delete('precio');
          if (orden) url.searchParams.set('orden', orden);
          else url.searchParams.delete('orden');
          
          window.history.pushState({}, '', url);

          // Agregar clase de loading
          productosGrid.classList.add('loading');
          const params = new URLSearchParams({
              ajax: '1',
              categoria: categoria,
              buscar: buscar,
              precio: precio,
              orden: orden
          });
          
          const xhr = new XMLHttpRequest();
          xhr.open('GET', './public/assets/productos.php?' + params.toString(), true);
          xhr.onload = function() {
              if (xhr.status === 200) {
                  setTimeout(() => {
                      productosGrid.innerHTML = xhr.responseText;
                      productosGrid.classList.remove('loading');
                      // Animar la entrada de los nuevos productos
                      const cards = productosGrid.querySelectorAll('.producto-card-wrapper');
                      cards.forEach((card, index) => {
                          card.style.opacity = '0';
                          card.style.transform = 'translateY(20px)';
                          setTimeout(() => {
                              card.style.transition = 'all 0.4s ease';
                              card.style.opacity = '1';
                              card.style.transform = 'translateY(0)';
                          }, index * 100);
                      });
                  }, 300);
              } else {
                  productosGrid.classList.remove('loading');
                  console.error('Error al cargar productos');
              }
          };
          xhr.onerror = function() {
              productosGrid.classList.remove('loading');
              console.error('Error de conexión');
          };
          xhr.send();
      }

      // Hacer la función global para que pueda ser llamada desde index.php
      window.aplicarFiltros = aplicarFiltros;

      window.limpiarFiltros = function() {
          document.getElementById('buscar-producto').value = '';
          document.getElementById('clear-search').style.display = 'none';
          document.getElementById('categoria').value = '';
          document.getElementById('filtro-precio').value = '';
          document.getElementById('filtro-orden').value = '';
          aplicarFiltros();
      };

      // Animar productos iniciales
      const initialCards = productosGrid.querySelectorAll('.producto-card-wrapper');
      initialCards.forEach((card, index) => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          setTimeout(() => {
              card.style.transition = 'all 0.4s ease';
              card.style.opacity = '1';
              card.style.transform = 'translateY(0)';
          }, index * 100);
      });

      // Manejar el back/forward del navegador para actualizar el grid sin recargar
      window.addEventListener('popstate', function() {
          const categoria = new URL(window.location).searchParams.get('categoria') || '';
          categoriaSelect.value = categoria;
          productosGrid.classList.add('loading');
          const xhr = new XMLHttpRequest();
          xhr.open('GET', './public/assets/productos.php?categoria=' + encodeURIComponent(categoria) + '&ajax=1', true);
          xhr.onload = function() {
              if (xhr.status === 200) {
                  setTimeout(() => {
                      productosGrid.innerHTML = xhr.responseText;
                      productosGrid.classList.remove('loading');
                      const cards = productosGrid.querySelectorAll('.producto-card-wrapper');
                      cards.forEach((card, index) => {
                          card.style.opacity = '0';
                          card.style.transform = 'translateY(20px)';
                          setTimeout(() => {
                              card.style.transition = 'all 0.4s ease';
                              card.style.opacity = '1';
                              card.style.transform = 'translateY(0)';
                          }, index * 100);
                      });
                  }, 300);
              } else {
                  productosGrid.classList.remove('loading');
                  console.error('Error al cargar productos');
              }
          };
          xhr.onerror = function() {
              productosGrid.classList.remove('loading');
              console.error('Error de conexión');
          };
          xhr.send();
      });
  });
</script>