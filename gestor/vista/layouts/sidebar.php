        <?php
        $controladorActual = $_GET['c'] ?? '';
        $menuItems = [
            ['icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'url' => 'index.php?c=dashboard&m=index', 'active' => $controladorActual === 'dashboard'],
            ['icon' => 'bi-box-seam', 'label' => 'Productos', 'url' => 'index.php?c=productos&m=index', 'active' => $controladorActual === 'productos'],
            ['icon' => 'bi-people', 'label' => 'Clientes', 'url' => '#', 'disabled' => true],
            ['icon' => 'bi-receipt', 'label' => 'Facturas', 'url' => '#', 'disabled' => true],
            ['icon' => 'bi-bookmark', 'label' => 'Apartados', 'url' => '#', 'disabled' => true],
            ['icon' => 'bi-tools', 'label' => 'Servicios', 'url' => '#', 'disabled' => true],
            ['icon' => 'bi-person-badge', 'label' => 'Empleados', 'url' => '#', 'disabled' => true],
        ];
        ?>

        <aside class="sidebar d-none d-lg-block">
            <nav class="nav flex-column py-3">
                <?php foreach ($menuItems as $item): ?>
                    <?php if (!empty($item['disabled'])): ?>
                        <span class="nav-link text-muted disabled">
                            <i class="bi <?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?> me-2"></i>
                            <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    <?php else: ?>
                        <a class="nav-link<?= !empty($item['active']) ? ' active' : '' ?>"
                           href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>">
                            <i class="bi <?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?> me-2"></i>
                            <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
        </aside>

        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menú</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <nav class="nav flex-column">
                    <?php foreach ($menuItems as $item): ?>
                        <?php if (!empty($item['disabled'])): ?>
                            <span class="nav-link text-muted disabled px-3">
                                <i class="bi <?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?> me-2"></i>
                                <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        <?php else: ?>
                            <a class="nav-link px-3<?= !empty($item['active']) ? ' active' : '' ?>"
                               href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>">
                                <i class="bi <?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?> me-2"></i>
                                <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </nav>
            </div>
        </div>

        <main class="main-content flex-grow-1">
