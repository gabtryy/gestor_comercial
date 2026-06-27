            <div class="container-fluid py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1">Dashboard</h1>
                        <p class="text-muted mb-0">Resumen del día — <?= date('d/m/Y') ?></p>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-4">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Ventas hoy</p>
                                        <h2 class="h4 mb-0">$<?= number_format($ventasHoy, 2) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-success-subtle text-success">
                                        <i class="bi bi-currency-dollar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Facturas hoy</p>
                                        <h2 class="h4 mb-0"><?= number_format($facturasHoy) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-primary-subtle text-primary">
                                        <i class="bi bi-receipt-cutoff"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Apartados pendientes</p>
                                        <h2 class="h4 mb-0"><?= number_format($apartadosPendientes) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-warning-subtle text-warning">
                                        <i class="bi bi-bookmark"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Stock bajo</p>
                                        <h2 class="h4 mb-0"><?= number_format($stockBajo) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-danger-subtle text-danger">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <a href="index.php?c=productos&m=index"
                           class="card stat-card stat-card-link border-0 shadow-sm h-100 text-decoration-none">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Total productos</p>
                                        <h2 class="h4 mb-0 text-dark"><?= number_format($totalProductos) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-info-subtle text-info">
                                        <i class="bi bi-box-seam"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small mb-1">Total clientes</p>
                                        <h2 class="h4 mb-0"><?= number_format($totalClientes) ?></h2>
                                    </div>
                                    <span class="stat-icon bg-secondary-subtle text-secondary">
                                        <i class="bi bi-people"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h2 class="h6 mb-0">Últimas facturas</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Empleado</th>
                                        <th>Monto</th>
                                        <th>Pago</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($ultimasFacturas)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                No hay facturas registradas.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($ultimasFacturas as $factura): ?>
                                            <tr>
                                                <td><?= (int) $factura['id_factura'] ?></td>
                                                <td><?= htmlspecialchars($factura['cliente'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($factura['empleado'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>$<?= number_format((float) $factura['monto_total'], 2) ?></td>
                                                <td>
                                                    <span class="badge bg-light text-dark text-capitalize">
                                                        <?= htmlspecialchars(str_replace('_', ' ', $factura['metodo_pago']), ENT_QUOTES, 'UTF-8') ?>
                                                    </span>
                                                </td>
                                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($factura['fecha_facturacion'])), ENT_QUOTES, 'UTF-8') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
