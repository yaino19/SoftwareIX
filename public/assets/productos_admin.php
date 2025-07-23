<div class="admin-panel">
    <div class="container">
        <div class="admin-header">
            <h2><i class="fas fa-box"></i> Panel de Productos</h2>
            <button class="btn-nuevo" onclick="abrirModalProducto()">
                <i class="fas fa-plus"></i> Nuevo Producto
            </button>
        </div>

        <!-- Filtros -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-filter"></i> Filtros de Búsqueda</h3>
                <button class="btn-collapse" onclick="toggleFiltros()">
                    <i class="fas fa-chevron-up" id="collapse-icon"></i>
                </button>
            </div>
            <div class="filtros-content" id="filtros-content">
                <div class="filtros-grid">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="filtro-buscar" placeholder="Buscar producto..." onkeyup="filtrarProductos()">
                    </div>
                    <div class="filter-select">
                        <label>Categoría</label>
                        <select id="filtro-categoria" onchange="filtrarProductos()">
                            <option value="">Todas las categorías</option>
                        </select>
                    </div>
                    <div class="filter-select">
                        <label>Rango de Precio</label>
                        <select id="filtro-precio" onchange="filtrarProductos()">
                            <option value="">Todos los precios</option>
                            <option value="0-10">$0 - $10</option>
                            <option value="10-20">$10 - $20</option>
                            <option value="20-50">$20 - $50</option>
                            <option value="50+">$50+</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button class="btn-reset" onclick="limpiarFiltros()">
                            <i class="fas fa-undo"></i>
                            Limpiar
                        </button>
                        <button class="btn-export" onclick="exportarProductos()">
                            <i class="fas fa-download"></i>
                            Exportar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number" id="total-categorias">0</div>
                    <div class="stat-label">Categorías</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number" id="precio-promedio">$0</div>
                    <div class="stat-label">Precio Promedio</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number" id="productos-mes"></div>
                    <div class="stat-label">Total de Productos</div>
                </div>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Lista de Productos</h3>
                <div class="table-controls">
                    <div class="view-options">
                        <button class="view-btn active" onclick="cambiarVista('table')" data-view="table">
                            <i class="fas fa-table"></i>
                        </button>
                        <button class="view-btn" onclick="cambiarVista('grid')" data-view="grid">
                            <i class="fas fa-th"></i>
                        </button>
                    </div>
                    <div class="entries-per-page">
                        <label>Mostrar:</label>
                        <select id="entries-per-page" onchange="cambiarEntradas()">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="modern-table" id="tabla-productos">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" onchange="toggleSelectAll()">
                            </th>
                            <th class="sortable" onclick="ordenarTabla('id')">
                                ID <i class="fas fa-sort"></i>
                            </th>
                            <th>Imagen</th>
                            <th class="sortable" onclick="ordenarTabla('nombre')">
                                Nombre <i class="fas fa-sort"></i>
                            </th>
                            <th>Descripción</th>
                            <th class="sortable" onclick="ordenarTabla('precio')">
                                Precio <i class="fas fa-sort"></i>
                            </th>
                            <th class="sortable" onclick="ordenarTabla('categoria')">
                                Categoría <i class="fas fa-sort"></i>
                            </th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="productos-tbody">
                        <!-- Los productos se cargan aquí via AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <div class="table-info">
                    <span id="table-info">Mostrando 0 de 0 productos</span>
                </div>
                <div class="table-pagination" id="paginacion">
                    <!-- La paginación se genera dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear/editar producto -->
<div class="modal-overlay" id="modal-producto">
    <div class="modal-content-large">
        <div class="modal-header">
            <h3 id="modal-titulo">
                <i class="fas fa-plus"></i>
                Nuevo Producto
            </h3>
            <button class="modal-close" onclick="cerrarModalProducto()">&times;</button>
        </div>
        <form id="form-producto" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" id="producto-id" name="id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="producto-nombre">
                            <i class="fas fa-tag"></i>
                            Nombre del Producto <span class="required">*</span>
                        </label>
                        <input type="text" id="producto-nombre" name="nombre" required placeholder="Ej: Camiseta UTP">
                    </div>
                    <div class="form-group">
                        <label for="producto-precio">
                            <i class="fas fa-dollar-sign"></i>
                            Precio <span class="required">*</span>
                        </label>
                        <input type="number" id="producto-precio" name="precio" step="0.01" min="0" required placeholder="0.00">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="producto-categoria">
                            <i class="fas fa-tags"></i>
                            Categoría <span class="required">*</span>
                        </label>
                        <select id="producto-categoria" name="categoria_id" required>
                            <option value="">Seleccionar categoría</option>
                            <!-- Las categorías se cargan dinámicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-image"></i>
                            Imagen del Producto
                        </label>
                        <div class="file-input-wrapper">
                            <input type="file" id="producto-imagen" name="imagen" accept="image/*" class="file-input-custom">
                            <label for="producto-imagen" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Seleccionar imagen</span>
                            </label>
                        </div>
                        <div class="imagen-preview" id="imagen-preview"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="producto-descripcion">
                        <i class="fas fa-align-left"></i>
                        Descripción
                    </label>
                    <textarea id="producto-descripcion" name="descripcion" rows="4" placeholder="Describe las características del producto..."></textarea>
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancelar" onclick="cerrarModalProducto()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button type="submit" class="btn-guardar" id="btn-guardar">
                    <span class="loading-spinner"></span>
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Guardar</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal-overlay" id="modal-confirmar">
    <div class="modal-content-small">
        <div class="modal-header">
            <h3>
                <i class="fas fa-exclamation-triangle"></i>
                Confirmar Eliminación
            </h3>
            <button class="modal-close" onclick="cerrarModalConfirmar()">&times;</button>
        </div>
        <div class="modal-body">
            <i class="fas fa-trash-alt"></i>
            <p>¿Estás seguro de que deseas eliminar este producto?</p>
            <p>Esta acción no se puede deshacer.</p>
            <p><strong id="producto-eliminar-nombre"></strong></p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-cancelar" onclick="cerrarModalConfirmar()">
                <i class="fas fa-times"></i>
                Cancelar
            </button>
            <button type="button" class="btn-eliminar" onclick="confirmarEliminar()" id="btn-confirmar-eliminar">
                <span class="loading-spinner"></span>
                <i class="fas fa-trash"></i>
                <span class="btn-text">Eliminar</span>
            </button>
        </div>
    </div>
</div>

<style>
    .admin-panel {
        padding: 30px 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 0 20px;
    }

    .admin-header h2 {
        color: #2c3e50;
        font-size: 2.2em;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
        font-weight: 700;
    }

    .btn-nuevo {
        background: rgb(27, 8, 29);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1.1em;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 32px rgba(27, 8, 29, 0.3);
    }

    .btn-nuevo:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(27, 8, 29, 0.4);
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.18);
    }

    .card-header {
        background: rgb(27, 8, 29);
        color: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.3em;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-collapse {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-collapse:hover {
        background: rgba(255,255,255,0.3);
    }

    /* Filtros modernos */
    .filtros-content {
        padding: 25px;
        transition: all 0.3s ease;
    }

    .filtros-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 20px;
        align-items: end;
    }

    .search-box {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: rgb(27, 8, 29);
        font-size: 1.1em;
    }

    .search-box input {
        width: 100%;
        padding: 15px 15px 15px 45px;
        border: 2px solid #e1e8ed;
        border-radius: 12px;
        font-size: 1em;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .search-box input:focus {
        outline: none;
        border-color: rgb(27, 8, 29);
        background: white;
        box-shadow: 0 0 20px rgba(27, 8, 29, 0.1);
    }

    .filter-select {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-select label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9em;
    }

    .filter-select select {
        padding: 12px 15px;
        border: 2px solid #e1e8ed;
        border-radius: 10px;
        font-size: 1em;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .filter-select select:focus {
        outline: none;
        border-color: rgb(27, 8, 29);
        background: white;
    }

    .filter-actions {
        display: flex;
        gap: 10px;
    }

    .btn-reset, .btn-export {
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset {
        background: #e74c3c;
        color: white;
    }

    .btn-reset:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }

    .btn-export {
        background: #27ae60;
        color: white;
    }

    .btn-export:hover {
        background: #229954;
        transform: translateY(-2px);
    }

    /* Estadísticas */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .stat-card:nth-child(1) { border-left-color: #3498db; }
    .stat-card:nth-child(2) { border-left-color: #e74c3c; }
    .stat-card:nth-child(3) { border-left-color: #f39c12; }
    .stat-card:nth-child(4) { border-left-color: #27ae60; }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5em;
        color: white;
    }

    .stat-card:nth-child(1) .stat-icon { background: #3498db; }
    .stat-card:nth-child(2) .stat-icon { background: #e74c3c; }
    .stat-card:nth-child(3) .stat-icon { background: #f39c12; }
    .stat-card:nth-child(4) .stat-icon { background: #27ae60; }

    .stat-number {
        font-size: 2em;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #7f8c8d;
        font-size: 0.9em;
        font-weight: 500;
    }

    /* Controles de tabla */
    .table-controls {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .view-options {
        display: flex;
        background: rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 4px;
    }

    .view-btn {
        background: transparent;
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-btn.active {
        background: rgba(255,255,255,0.3);
    }

    .entries-per-page {
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-size: 0.9em;
    }

    .entries-per-page select {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
    }

    /* Tabla moderna */
    .table-wrapper {
        overflow-x: auto;
        background: white;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .modern-table th {
        background: #f8f9fa;
        color: #2c3e50;
        padding: 18px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 0.9em;
        border-bottom: 3px solid #e9ecef;
        position: relative;
    }

    .modern-table th.sortable {
        cursor: pointer;
        user-select: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .modern-table th.sortable:hover {
        background: #e9ecef;
        color: rgb(27, 8, 29);
    }

    .modern-table th.sortable i {
        margin-left: 5px;
        opacity: 0.5;
        transition: all 0.3s ease;
        font-size: 0.8em;
    }

    .modern-table th.sortable:hover i {
        opacity: 1;
        color: rgb(27, 8, 29);
        transform: scale(1.1);
    }

    .modern-table th.sortable i.fa-sort-up,
    .modern-table th.sortable i.fa-sort-down {
        opacity: 1;
        color: rgb(27, 8, 29);
        transform: scale(1.1);
    }

    .modern-table td {
        padding: 18px 15px;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
        transition: all 0.3s ease;
    }

    .modern-table tr {
        transition: all 0.3s ease;
    }

    .modern-table tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .modern-table tr.selected {
        background: #e8f4fd;
        border-left: 4px solid #3498db;
    }

    .producto-imagen {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .producto-imagen:hover {
        transform: scale(1.1);
        border-color: rgb(27, 8, 29);
    }

    .producto-nombre {
        font-weight: 600;
        color: #2c3e50;
        font-size: 1.1em;
    }

    .producto-precio {
        color: #27ae60;
        font-weight: 700;
        font-size: 1.2em;
    }

    .producto-estado {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.8em;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
        min-width: 90px;
    }

    .estado-activo {
        background: #d4edda;
        color: #155724;
    }

    .estado-activo:hover {
        background: #c3e6cb;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(21, 87, 36, 0.3);
    }

    .estado-inactivo {
        background: #f8d7da;
        color: #721c24;
    }

    .estado-inactivo:hover {
        background: #f5c6cb;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(114, 28, 36, 0.3);
    }

    /* Acciones mejoradas */
    .acciones {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-accion {
        padding: 10px 15px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.85em;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
        min-width: 85px;
        justify-content: center;
        text-align: center;
    }

    .btn-editar {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
    }

    .btn-editar:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
    }

    .btn-eliminar {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
    }

    .btn-eliminar:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
    }

    /* Footer de tabla */
    .table-footer {
        padding: 20px 25px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-info {
        color: #6c757d;
        font-size: 0.9em;
    }

    /* Paginación moderna */
    .table-pagination {
        display: flex;
        gap: 5px;
    }

    .table-pagination button {
        padding: 10px 15px;
        border: 2px solid #e9ecef;
        background: white;
        color: #2c3e50;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .table-pagination button:hover {
        border-color: rgb(27, 8, 29);
        background: rgb(27, 8, 29);
        color: white;
        transform: translateY(-2px);
    }

    .table-pagination button.active {
        background: rgb(27, 8, 29);
        border-color: rgb(27, 8, 29);
        color: white;
        box-shadow: 0 4px 15px rgba(27, 8, 29, 0.3);
    }

    /* Modales modernos */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-overlay.show {
        display: flex;
        opacity: 1;
    }

    .modal-content-large,
    .modal-content-small {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        transform: scale(0.7);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .modal-overlay.show .modal-content-large,
    .modal-overlay.show .modal-content-small {
        transform: scale(1);
    }

    .modal-content-large {
        width: 90%;
        max-width: 700px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-content-small {
        width: 90%;
        max-width: 450px;
    }

    .modal-header {
        background: rgb(27, 8, 29);
        color: white;
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: none;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.4em;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2em;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 30px;
    }

    /* Formulario moderno */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95em;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-group label .required {
        color: #e74c3c;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 15px 18px;
        border: 2px solid #e1e8ed;
        border-radius: 12px;
        font-size: 1em;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: rgb(27, 8, 29);
        background: white;
        box-shadow: 0 0 20px rgba(27, 8, 29, 0.1);
        transform: translateY(-2px);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Input de archivo personalizado */
    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-custom {
        display: none;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px 18px;
        border: 2px dashed #e1e8ed;
        border-radius: 12px;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        justify-content: center;
    }

    .file-input-label:hover {
        border-color: rgb(27, 8, 29);
        background: #f0f2ff;
    }

    .file-input-label i {
        font-size: 1.2em;
        color: rgb(27, 8, 29);
    }

    .imagen-preview {
        margin-top: 15px;
        text-align: center;
    }

    .imagen-preview img {
        max-width: 200px;
        max-height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid #e9ecef;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .imagen-preview img:hover {
        transform: scale(1.05);
        border-color: rgb(27, 8, 29);
    }

    /* Acciones del modal */
    .modal-actions {
        padding: 25px 30px;
        background: #f8f9fa;
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        border-top: 1px solid #e9ecef;
    }

    .btn-cancelar,
    .btn-guardar,
    .btn-eliminar {
        padding: 12px 25px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1em;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 120px;
        justify-content: center;
    }

    .btn-cancelar {
        background: #6c757d;
        color: white;
    }

    .btn-cancelar:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-guardar {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .btn-guardar:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }

    .btn-guardar:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-eliminar {
        background: linear-gradient(135deg, #dc3545, #e74c3c);
        color: white;
    }

    .btn-eliminar:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    /* Modal de confirmación especial */
    .modal-content-small .modal-body {
        text-align: center;
        padding: 40px 30px;
    }

    .modal-content-small .modal-body i {
        font-size: 4em;
        color: #e74c3c;
        margin-bottom: 20px;
    }

    .modal-content-small .modal-body p {
        font-size: 1.1em;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .modal-content-small .modal-body strong {
        color: #e74c3c;
        font-size: 1.2em;
    }

    /* Loading spinner */
    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid #ffffff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive para modales */
    @media (max-width: 768px) {
        .modal-content-large,
        .modal-content-small {
            width: 95%;
            margin: 20px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .modal-actions {
            flex-direction: column;
        }
        
        .modal-header {
            padding: 20px;
        }
        
        .modal-body {
            padding: 20px;
        }

        .acciones {
            flex-direction: column;
            gap: 5px;
        }

        .btn-accion {
            width: 100%;
            min-width: auto;
        }

        .filtros-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .filter-actions {
            justify-content: center;
        }
    }

    /* Animaciones */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dashboard-card {
        animation: fadeInUp 0.6s ease;
    }

    .stat-card {
        animation: fadeInUp 0.6s ease;
    }

    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.2s; }
    .stat-card:nth-child(4) { animation-delay: 0.3s; }
</style>

<script>
let paginaActual = 1;
let productoEliminarId = null;

document.addEventListener('DOMContentLoaded', function() {
    cargarCategorias();
    cargarProductos();
    cargarEstadisticasGenerales(); // Cargar estadísticas al inicio
    
    // Inicializar ordenamiento por defecto
    ordenActual = {
        columna: 'id',
        direccion: 'desc'
    };
    actualizarIconosOrden('id', 'desc');
});

// Cargar categorías para los filtros
function cargarCategorias() {
    fetch('./public/assets/productos_admin_api.php?action=categorias')
    .then(response => response.json())
    .then(categorias => {
        const filtroCategoria = document.getElementById('filtro-categoria');
        const productoCategoria = document.getElementById('producto-categoria');
        
        // Limpiar opciones existentes (excepto la primera)
        filtroCategoria.innerHTML = '<option value="">Todas las categorías</option>';
        productoCategoria.innerHTML = '<option value="">Seleccionar categoría</option>';
        
        // Agregar categorías
        categorias.forEach(categoria => {
            const option1 = new Option(categoria.nombre, categoria.id);
            const option2 = new Option(categoria.nombre, categoria.id);
            filtroCategoria.add(option1);
            productoCategoria.add(option2);
        });
    })
    .catch(error => {
        console.error('Error cargando categorías:', error);
    });
}

// Cargar productos con filtros
function cargarProductos(pagina = 1) {
    paginaActual = pagina;
    
    const params = new URLSearchParams({
        action: 'listar',
        buscar: document.getElementById('filtro-buscar').value,
        categoria: document.getElementById('filtro-categoria').value,
        precio: document.getElementById('filtro-precio').value,
        orden_campo: ordenActual.columna,
        orden_direccion: ordenActual.direccion,
        entries_per_page: document.getElementById('entries-per-page').value,
        pagina: pagina
    });
    
    fetch(`./public/assets/productos_admin_api.php?${params}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarProductos(data.productos, data.estadisticas);
            mostrarPaginacion(data.totalPaginas, pagina);
            actualizarInfoTabla(data.totalProductos, data.productos.length, pagina);
        } else {
            console.error('Error:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Mostrar productos en la tabla
function mostrarProductos(productos, estadisticas = null) {
    const tbody = document.getElementById('productos-tbody');
    
    if (productos.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" style="text-align: center; padding: 60px 20px;">
                    <div style="color: #6c757d; font-size: 1.2em;">
                        <i class="fas fa-box-open" style="font-size: 3em; margin-bottom: 15px; color: #dee2e6;"></i>
                        <br>
                        <strong>No se encontraron productos</strong>
                        <br>
                        <small style="color: #adb5bd; margin-top: 10px; display: block;">
                            ${document.getElementById('filtro-buscar').value || document.getElementById('filtro-categoria').value || document.getElementById('filtro-precio').value ? 
                                'Intenta ajustar los filtros de búsqueda' : 
                                'Comienza agregando tu primer producto'
                            }
                        </small>
                        ${!document.getElementById('filtro-buscar').value && !document.getElementById('filtro-categoria').value && !document.getElementById('filtro-precio').value ? 
                            '<button onclick="abrirModalProducto()" style="margin-top: 15px; background: rgb(27, 8, 29); color: white; border: none; padding: 10px 20px; border-radius: 25px; cursor: pointer; font-weight: 600;"><i class="fas fa-plus"></i> Agregar Producto</button>' : 
                            ''
                        }
                    </div>
                </td>
            </tr>
        `;
        // Actualizar estadísticas incluso cuando no hay productos mostrados
        if (estadisticas) {
            actualizarEstadisticas(productos, estadisticas);
        }
        return;
    }
    
    tbody.innerHTML = productos.map(producto => `
        <tr>
            <td>
                <input type="checkbox" class="row-checkbox" value="${producto.id}">
            </td>
            <td>${producto.id}</td>
            <td>
                ${producto.imagen_url ? 
                    `<img src="./public/assets/${producto.imagen_url}" alt="${producto.nombre}" class="producto-imagen">` : 
                    '<div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;"><i class="fas fa-image"></i></div>'
                }
            </td>
            <td class="producto-nombre">${producto.nombre}</td>
            <td>${producto.descripcion || 'Sin descripción'}</td>
            <td class="producto-precio">$${parseFloat(producto.precio).toFixed(2)}</td>
            <td>${producto.categoria_nombre || 'Sin categoría'}</td>
            <td>
                <button class="producto-estado estado-${producto.activo == 1 ? 'activo' : 'inactivo'}" 
                        onclick="cambiarEstadoProducto(${producto.id}, ${producto.activo})"
                        title="Click para cambiar estado">
                    <i class="fas fa-${producto.activo == 1 ? 'check-circle' : 'times-circle'}"></i>
                    ${producto.activo == 1 ? 'Activo' : 'Inactivo'}
                </button>
            </td>
            <td>
                <div class="acciones">
                    <button class="btn-accion btn-editar" onclick="editarProducto(${producto.id})" title="Editar producto">
                        <i class="fas fa-edit"></i>
                        <span>Editar</span>
                    </button>
                    <button class="btn-accion btn-eliminar" onclick="confirmarEliminarProducto(${producto.id}, '${producto.nombre}')" title="Eliminar producto">
                        <i class="fas fa-trash"></i>
                        <span>Eliminar</span>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
    
    // Usar estadísticas reales si están disponibles, sino usar el cálculo local
    actualizarEstadisticas(productos, estadisticas);
}

// Nuevas funciones para las características adicionales
function toggleFiltros() {
    const content = document.getElementById('filtros-content');
    const icon = document.getElementById('collapse-icon');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.className = 'fas fa-chevron-up';
    } else {
        content.style.display = 'none';
        icon.className = 'fas fa-chevron-down';
    }
}

function cambiarVista(vista) {
    const buttons = document.querySelectorAll('.view-btn');
    buttons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.view === vista) {
            btn.classList.add('active');
        }
    });
    
    // Aquí puedes implementar la lógica para cambiar entre vista tabla y grid
    console.log('Cambiar vista a:', vista);
}

function cambiarEntradas() {
    const select = document.getElementById('entries-per-page');
    const valor = select.value;
    
    // Agregar parámetro entries_per_page a la URL
    const params = new URLSearchParams({
        action: 'listar',
        buscar: document.getElementById('filtro-buscar').value,
        categoria: document.getElementById('filtro-categoria').value,
        precio: document.getElementById('filtro-precio').value,
        orden_campo: ordenActual.columna,
        orden_direccion: ordenActual.direccion,
        entries_per_page: valor,
        pagina: 1
    });
    
    // Recargar productos con nueva cantidad
    cargarProductos(1);
}

function actualizarIconosOrden(columnaActiva, direccion) {
    // Resetear todos los iconos
    const headers = document.querySelectorAll('.sortable i');
    headers.forEach(icon => {
        icon.className = 'fas fa-sort';
        icon.style.opacity = '0.5';
    });
    
    // Actualizar icono de la columna activa
    const headerActivo = document.querySelector(`[onclick="ordenarTabla('${columnaActiva}')"] i`);
    if (headerActivo) {
        if (direccion === 'asc') {
            headerActivo.className = 'fas fa-sort-up';
        } else {
            headerActivo.className = 'fas fa-sort-down';
        }
        headerActivo.style.opacity = '1';
        headerActivo.style.color = 'rgb(27, 8, 29)';
    }
}

function actualizarInfoTabla(total, mostrados, pagina) {
    const entriesPorPagina = parseInt(document.getElementById('entries-per-page').value) || 10;
    const inicio = ((pagina - 1) * entriesPorPagina) + 1;
    const fin = Math.min(pagina * entriesPorPagina, total);
    
    document.getElementById('table-info').textContent = 
        `Mostrando ${inicio} - ${fin} de ${total} productos`;
}

function toggleSelectAll() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
        const row = checkbox.closest('tr');
        if (checkbox.checked) {
            row.classList.add('selected');
        } else {
            row.classList.remove('selected');
        }
    });
}

let ordenActual = {
    columna: '',
    direccion: 'asc'
};

function ordenarTabla(columna) {
    // Mostrar indicador de carga
    const tbody = document.getElementById('productos-tbody');
    tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 40px; color: rgb(27, 8, 29);"><i class="fas fa-spinner fa-spin" style="font-size: 2em; margin-bottom: 10px; color: rgb(27, 8, 29);"></i><br><strong>Ordenando productos...</strong><br><small style="color: #6c757d; margin-top: 5px; display: block;">Por favor espera un momento</small></td></tr>';
    
    // Cambiar dirección si es la misma columna
    if (ordenActual.columna === columna) {
        ordenActual.direccion = ordenActual.direccion === 'asc' ? 'desc' : 'asc';
    } else {
        ordenActual.columna = columna;
        ordenActual.direccion = 'asc';
    }
    
    // Actualizar iconos de ordenamiento
    actualizarIconosOrden(columna, ordenActual.direccion);
    
    // Cargar productos con nuevo ordenamiento con un pequeño delay para mostrar el feedback
    setTimeout(() => {
        cargarProductos(1);
    }, 300);
}

function exportarProductos() {
    // Mostrar mensaje de inicio
    mostrarMensaje('Preparando descarga...', 'info');
    
    // Obtener productos filtrados actuales
    const params = new URLSearchParams({
        action: 'exportar',
        buscar: document.getElementById('filtro-buscar').value,
        categoria: document.getElementById('filtro-categoria').value,
        precio: document.getElementById('filtro-precio').value,
        orden_campo: ordenActual.columna,
        orden_direccion: ordenActual.direccion
    });
    
    // Crear enlace de descarga
    const url = `./public/assets/productos_admin_api.php?${params}`;
    const link = document.createElement('a');
    link.href = url;
    link.download = `productos_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Mostrar mensaje de confirmación después de un pequeño delay
    setTimeout(() => {
        mostrarMensaje('Descarga de productos iniciada', 'success');
    }, 500);
}

function actualizarEstadisticas(productos, estadisticasReales = null) {
    // Si hay estadísticas reales, actualiza directamente las tarjetas
    if (estadisticasReales) {
        document.getElementById('total-categorias').textContent = estadisticasReales.totalCategorias || 0;
        document.getElementById('precio-promedio').textContent = '$' + (estadisticasReales.precioPromedio ? estadisticasReales.precioPromedio.toFixed(2) : '0.00');
        document.getElementById('productos-mes').textContent = estadisticasReales.productosMes || 0;
    } else {
        // Si no hay estadísticas reales, cargar desde la API
        cargarEstadisticasGenerales();
    }
}

// Nueva función para cargar estadísticas generales
function cargarEstadisticasGenerales() {
    fetch('./public/assets/productos_admin_api.php?action=estadisticas')
    .then(response => response.json())
    .then(data => {
        if (data.success && data.estadisticas) {
            const stats = data.estadisticas;
            // Eliminado: total-productos
            document.getElementById('total-categorias').textContent = stats.totalCategorias || 0;
            document.getElementById('precio-promedio').textContent = '$' + (stats.precioPromedio ? stats.precioPromedio.toFixed(2) : '0.00');
            document.getElementById('productos-mes').textContent = stats.productosMes || 0;
        }
    })
    .catch(error => {
        console.error('Error cargando estadísticas:', error);
        // Mostrar valores por defecto en caso de error
        // Eliminado: total-productos
        document.getElementById('total-categorias').textContent = '0';
        document.getElementById('precio-promedio').textContent = '$0.00';
        document.getElementById('productos-mes').textContent = '0';
    });
}

// Agregar event listeners para checkboxes individuales
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('row-checkbox')) {
        const row = e.target.closest('tr');
        if (e.target.checked) {
            row.classList.add('selected');
        } else {
            row.classList.remove('selected');
        }
        
        // Actualizar checkbox "select all"
        const allCheckboxes = document.querySelectorAll('.row-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        const selectAll = document.getElementById('select-all');
        
        selectAll.checked = allCheckboxes.length === checkedCheckboxes.length;
        selectAll.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
    }
});

// Mostrar paginación
function mostrarPaginacion(totalPaginas, paginaActual) {
    const paginacion = document.getElementById('paginacion');
    
    if (totalPaginas <= 1) {
        paginacion.innerHTML = '';
        return;
    }
    
    let html = '';
    
    // Botón anterior
    if (paginaActual > 1) {
        html += `<button onclick="cargarProductos(${paginaActual - 1})">« Anterior</button>`;
    }
    
    // Números de página
    for (let i = 1; i <= totalPaginas; i++) {
        if (i === paginaActual) {
            html += `<button class="active">${i}</button>`;
        } else {
            html += `<button onclick="cargarProductos(${i})">${i}</button>`;
        }
    }
    
    // Botón siguiente
    if (paginaActual < totalPaginas) {
        html += `<button onclick="cargarProductos(${paginaActual + 1})">Siguiente »</button>`;
    }
    
    paginacion.innerHTML = html;
}

// Filtrar productos
function filtrarProductos() {
    cargarProductos(1);
}

// Limpiar filtros
function limpiarFiltros() {
    document.getElementById('filtro-buscar').value = '';
    document.getElementById('filtro-categoria').value = '';
    document.getElementById('filtro-precio').value = '';
    cargarProductos(1);
}

// Abrir modal para nuevo producto
function abrirModalProducto(id = null) {
    const modal = document.getElementById('modal-producto');
    const titulo = document.getElementById('modal-titulo');
    const form = document.getElementById('form-producto');
    
    form.reset();
    document.getElementById('imagen-preview').innerHTML = '';
    
    if (id) {
        titulo.innerHTML = '<i class="fas fa-edit"></i> Editar Producto';
        cargarDatosProducto(id);
    } else {
        titulo.innerHTML = '<i class="fas fa-plus"></i> Nuevo Producto';
        document.getElementById('producto-id').value = '';
    }
    
    // Mostrar modal con animación
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

// Cargar datos del producto para editar
function cargarDatosProducto(id) {
    // Mostrar loading en el botón
    const btn = document.getElementById('btn-guardar');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Cargando...';
    
    fetch(`./public/assets/productos_admin_api.php?action=obtener&id=${id}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const producto = data.producto;
            document.getElementById('producto-id').value = producto.id;
            document.getElementById('producto-nombre').value = producto.nombre;
            document.getElementById('producto-descripcion').value = producto.descripcion || '';
            document.getElementById('producto-precio').value = producto.precio;
            document.getElementById('producto-categoria').value = producto.categoria_id || '';
            
            if (producto.imagen_url) {
                document.getElementById('imagen-preview').innerHTML = 
                    `<img src="./public/assets/${producto.imagen_url}" alt="${producto.nombre}">`;
            }
        } else {
            mostrarMensaje('Error al cargar el producto: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error de conexión al cargar el producto', 'error');
    })
    .finally(() => {
        // Restaurar botón
        btn.disabled = false;
        btn.querySelector('.btn-text').textContent = 'Guardar';
    });
}

// Cerrar modal de producto con animación
function cerrarModalProducto() {
    const modal = document.getElementById('modal-producto');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

// Cambiar estado del producto
function cambiarEstadoProducto(id, estadoActual) {
    const nuevoEstado = estadoActual == 1 ? 0 : 1;
    const estadoTexto = nuevoEstado == 1 ? 'activar' : 'desactivar';
    
    if (!confirm(`¿Estás seguro de que deseas ${estadoTexto} este producto?`)) {
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'cambiar_estado');
    formData.append('id', id);
    formData.append('estado', nuevoEstado);
    
    fetch('./public/assets/productos_admin_api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cargarProductos(paginaActual);
            cargarEstadisticasGenerales(); // Recargar estadísticas
            mostrarMensaje(`Producto ${estadoTexto}do correctamente`, 'success');
            notificarActualizacionProductos();
            recargarProductosPublicos();
        } else {
            mostrarMensaje('Error al cambiar el estado: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error de conexión', 'error');
    });
}

// Editar producto
function editarProducto(id) {
    abrirModalProducto(id);
}

// Confirmar eliminar producto con animación
function confirmarEliminarProducto(id, nombre) {
    productoEliminarId = id;
    document.getElementById('producto-eliminar-nombre').textContent = nombre;
    
    const modal = document.getElementById('modal-confirmar');
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

// Cerrar modal de confirmación con animación
function cerrarModalConfirmar() {
    const modal = document.getElementById('modal-confirmar');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
    productoEliminarId = null;
}

// Confirmar eliminación mejorada
function confirmarEliminar() {
    if (!productoEliminarId) return;
    
    const btn = document.getElementById('btn-confirmar-eliminar');
    const spinner = btn.querySelector('.loading-spinner');
    const text = btn.querySelector('.btn-text');
    
    // Mostrar loading
    btn.disabled = true;
    spinner.style.display = 'block';
    text.textContent = 'Eliminando...';
    
    const formData = new FormData();
    formData.append('action', 'eliminar');
    formData.append('id', productoEliminarId);
    
    fetch('./public/assets/productos_admin_api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cargarProductos(paginaActual);
            cargarEstadisticasGenerales(); // Recargar estadísticas
            cerrarModalConfirmar();
            mostrarMensaje('Producto eliminado correctamente', 'success');
            notificarActualizacionProductos();
            recargarProductosPublicos();
        } else {
            mostrarMensaje('Error al eliminar el producto: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error de conexión', 'error');
    })
    .finally(() => {
        // Restaurar botón
        btn.disabled = false;
        spinner.style.display = 'none';
        text.textContent = 'Eliminar';
    });
}

// Función global para recargar productos públicos (debe estar definida en productos.php)
function recargarProductosPublicos() {
    if (typeof window.recargarProductosPublicosAjax === 'function') {
        window.recargarProductosPublicosAjax();
    }
}

// Manejar envío del formulario mejorado
document.getElementById('form-producto').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('btn-guardar');
    const spinner = btn.querySelector('.loading-spinner');
    const text = btn.querySelector('.btn-text');
    const id = document.getElementById('producto-id').value;
    
    // Validaciones
    if (!document.getElementById('producto-nombre').value.trim()) {
        mostrarMensaje('El nombre del producto es obligatorio', 'error');
        return;
    }
    
    if (!document.getElementById('producto-precio').value || document.getElementById('producto-precio').value <= 0) {
        mostrarMensaje('El precio debe ser mayor a 0', 'error');
        return;
    }
    
    if (!document.getElementById('producto-categoria').value) {
        mostrarMensaje('Debe seleccionar una categoría', 'error');
        return;
    }
    
    // Mostrar loading
    btn.disabled = true;
    spinner.style.display = 'block';
    text.textContent = id ? 'Actualizando...' : 'Creando...';
    
    const formData = new FormData(this);
    formData.append('action', id ? 'actualizar' : 'crear');
    
    fetch('./public/assets/productos_admin_api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cargarProductos(paginaActual);
            cargarEstadisticasGenerales(); // Recargar estadísticas
            cerrarModalProducto();
            mostrarMensaje(id ? 'Producto actualizado correctamente' : 'Producto creado correctamente', 'success');
            notificarActualizacionProductos();
            recargarProductosPublicos();
        } else {
            mostrarMensaje('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error de conexión', 'error');
    })
    .finally(() => {
        // Restaurar botón
        btn.disabled = false;
        spinner.style.display = 'none';
        text.textContent = 'Guardar';
    });
});

// Preview de imagen mejorado
document.getElementById('producto-imagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagen-preview');
    const label = document.querySelector('.file-input-label span');
    
    if (file) {
        // Validar tipo de archivo
        if (!file.type.startsWith('image/')) {
            mostrarMensaje('Por favor selecciona una imagen válida', 'error');
            this.value = '';
            return;
        }
        
        // Validar tamaño (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            mostrarMensaje('La imagen no debe superar los 5MB', 'error');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            label.textContent = file.name;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
        label.textContent = 'Seleccionar imagen';
    }
});

// Función mejorada para mostrar mensajes
function mostrarMensaje(mensaje, tipo) {
    // Remover mensajes anteriores
    const mensajesAnteriores = document.querySelectorAll('.mensaje-toast');
    mensajesAnteriores.forEach(msg => msg.remove());
    
    const div = document.createElement('div');
    div.className = `mensaje-toast mensaje-${tipo}`;
    
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        info: 'fas fa-info-circle'
    };
    
    const colors = {
        success: '#28a745',
        error: '#dc3545',
        info: '#17a2b8'
    };
    
    div.innerHTML = `
        <i class="${icons[tipo]}"></i>
        <span>${mensaje}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; font-size: 1.2em; cursor: pointer; margin-left: 10px;">&times;</button>
    `;
    
    div.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        z-index: 10001;
        background: ${colors[tipo]};
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideInRight 0.3s ease, fadeOut 0.3s ease 4.7s;
        max-width: 400px;
    `;
    
    document.body.appendChild(div);
    
    // Remover después de 5 segundos
    setTimeout(() => {
        if (div.parentElement) {
            div.remove();
        }
    }, 5000);
}

// Mejorar función de filtros colapsibles
function toggleFiltros() {
    const content = document.getElementById('filtros-content');
    const icon = document.getElementById('collapse-icon');
    
    if (content.style.display === 'none' || !content.style.display) {
        content.style.display = 'block';
        icon.className = 'fas fa-chevron-up';
        // Animar la entrada
        content.style.opacity = '0';
        content.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            content.style.transition = 'all 0.3s ease';
            content.style.opacity = '1';
            content.style.transform = 'translateY(0)';
        }, 10);
    } else {
        content.style.transition = 'all 0.3s ease';
        content.style.opacity = '0';
        content.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            content.style.display = 'none';
            icon.className = 'fas fa-chevron-down';
        }, 300);
    }
}

// Cerrar modales al hacer click fuera
document.addEventListener('click', function(e) {
    const modales = document.querySelectorAll('.modal-overlay');
    modales.forEach(modal => {
        if (e.target === modal) {
            if (modal.id === 'modal-producto') {
                cerrarModalProducto();
            } else if (modal.id === 'modal-confirmar') {
                cerrarModalConfirmar();
            }
        }
    });
});

// Cerrar modales con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modalProducto = document.getElementById('modal-producto');
        const modalConfirmar = document.getElementById('modal-confirmar');
        
        if (modalProducto.classList.contains('show')) {
            cerrarModalProducto();
        } else if (modalConfirmar.classList.contains('show')) {
            cerrarModalConfirmar();
        }
    }
});

// Agregar estilos para las animaciones
const styleSheet = document.createElement('style');
styleSheet.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
`;
document.head.appendChild(styleSheet);

// Notificar a otras pestañas sobre actualización de productos
function notificarActualizacionProductos() {
    localStorage.setItem('productos_actualizados', Date.now());
}

// Escuchar evento de almacenamiento para recargar productos en otras pestañas
window.addEventListener('storage', function(event) {
    if (event.key === 'productos_actualizados') {
        cargarProductos(paginaActual);
    }
});
</script>