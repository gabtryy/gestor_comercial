<?php
$totalProductos = count($productos);
$stockBajo = 0;
$sinStock = 0;
$valorInventario = 0.0;

foreach ($productos as $p) {
    $stock = (int) $p['stock'];
    $minimo = (int) $p['stock_minimo'];
    $precio = (float) $p['precio_venta'];

    if ($stock <= 0) {
        $sinStock++;
    } elseif ($stock <= $minimo) {
        $stockBajo++;
    }

    $valorInventario += $stock * $precio;
}

$formulario = $formulario ?? [];
$abrirModal = $abrirModal ?? false;
?>
            <div class="container-fluid py-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <h1 class="h3 mb-1">Productos</h1>
                        <p class="text-muted mb-0">Inventario y catálogo de la papelería</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalNuevoProducto">
                        <i class="bi bi-plus-lg me-1"></i> Nuevo producto
                    </button>
                </div>

                <?php if (!empty($exito)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($exito, ENT_QUOTES, 'UTF-8') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Total productos</p>
                                        <h2 class="h4 mb-0"><?= number_format($totalProductos) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-info-subtle text-info">
                                        <i class="bi bi-box-seam"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Stock bajo</p>
                                        <h2 class="h4 mb-0"><?= number_format($stockBajo) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-warning-subtle text-warning">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Sin stock</p>
                                        <h2 class="h4 mb-0"><?= number_format($sinStock) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-danger-subtle text-danger">
                                        <i class="bi bi-x-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Valor inventario</p>
                                        <h2 class="h4 mb-0">$<?= number_format($valorInventario, 2) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-success-subtle text-success">
                                        <i class="bi bi-currency-dollar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h2 class="h6 mb-0">Listado de productos</h2>
                        <div class="input-group input-group-sm" style="max-width: 280px;">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="buscarProducto"
                                   placeholder="Buscar por nombre o código...">
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle" id="tablaProductos">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th class="text-end">Precio</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Mínimo</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($productos)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No hay productos registrados.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($productos as $producto): ?>
                                            <?php
                                            $stock = (int) $producto['stock'];
                                            $minimo = (int) $producto['stock_minimo'];
                                            if ($stock <= 0) {
                                                $estado = 'Sin stock';
                                                $badgeClass = 'bg-danger';
                                            } elseif ($stock <= $minimo) {
                                                $estado = 'Stock bajo';
                                                $badgeClass = 'bg-warning text-dark';
                                            } else {
                                                $estado = 'Disponible';
                                                $badgeClass = 'bg-success';
                                            }
                                            ?>
                                            <tr>
                                                <td><?= (int) $producto['id_producto'] ?></td>
                                                <td>
                                                    <?php if (!empty($producto['codigo_barras'])): ?>
                                                        <code><?= htmlspecialchars($producto['codigo_barras'], ENT_QUOTES, 'UTF-8') ?></code>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="fw-medium">
                                                    <?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                                </td>
                                                <td class="text-end">
                                                    $<?= number_format((float) $producto['precio_venta'], 2) ?>
                                                </td>
                                                <td class="text-center"><?= number_format($stock) ?></td>
                                                <td class="text-center"><?= number_format($minimo) ?></td>
                                                <td class="text-center">
                                                    <span class="badge <?= $badgeClass ?>"><?= $estado ?></span>
                                                </td>
                                                <td class="text-end text-nowrap">
                                                    <a href="index.php?c=productos&m=editar&id=<?= (int) $producto['id_producto'] ?>"
                                                       class="btn btn-sm btn-outline-primary" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form method="post" action="index.php?c=productos&m=eliminar"
                                                          class="d-inline"
                                                          onsubmit="return confirm(<?= json_encode('¿Eliminar «' . $producto['nombre'] . '»? Esta acción no se puede deshacer.', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>);">
                                                        <input type="hidden" name="id_producto"
                                                               value="<?= (int) $producto['id_producto'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-labelledby="modalNuevoProductoLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <form method="post" action="index.php?c=productos&m=guardar">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalNuevoProductoLabel">Registrar nuevo producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger py-2" role="alert">
                                        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                <?php endif; ?>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="codigo_barras" class="form-label">Código de barras</label>
                                        <input type="text" class="form-control" id="codigo_barras" name="codigo_barras"
                                               maxlength="50" placeholder="Opcional"
                                               value="<?= htmlspecialchars($formulario['codigo_barras'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                               maxlength="150" required
                                               value="<?= htmlspecialchars($formulario['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                                  placeholder="Opcional"><?= htmlspecialchars($formulario['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="precio_venta" class="form-label">Precio de venta <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="precio_venta" name="precio_venta"
                                                   min="0" step="0.01" required
                                                   value="<?= htmlspecialchars($formulario['precio_venta'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="stock" class="form-label">Stock inicial <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                               min="0" step="1" required
                                               value="<?= htmlspecialchars($formulario['stock'] ?? '0', ENT_QUOTES, 'UTF-8') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="stock_minimo" class="form-label">Stock mínimo <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="stock_minimo" name="stock_minimo"
                                               min="0" step="1" required
                                               value="<?= htmlspecialchars($formulario['stock_minimo'] ?? '5', ENT_QUOTES, 'UTF-8') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i> Guardar producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
            <?php if ($abrirModal): ?>
            document.addEventListener('DOMContentLoaded', function () {
                new bootstrap.Modal(document.getElementById('modalNuevoProducto')).show();
            });
            <?php endif; ?>

            document.getElementById('buscarProducto')?.addEventListener('input', function () {
                const termino = this.value.toLowerCase().trim();
                document.querySelectorAll('#tablaProductos tbody tr').forEach(function (fila) {
                    if (fila.cells.length < 2) return;
                    const texto = fila.textContent.toLowerCase();
                    fila.style.display = texto.includes(termino) ? '' : 'none';
                });
            });
            </script>
