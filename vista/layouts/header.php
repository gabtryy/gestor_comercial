<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Papelería', ENT_QUOTES, 'UTF-8') ?> — Sistema Papelería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <button class="btn btn-primary d-lg-none me-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarOffcanvas">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand" href="index.php?c=dashboard&m=index">Papelería</a>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <span class="text-white-50 small d-none d-sm-inline">
                    <?= htmlspecialchars($usuario['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </span>
                <span class="badge bg-light text-primary text-capitalize">
                    <?= htmlspecialchars($usuario['rol'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </span>
                <a href="index.php?c=auth&m=logout" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="d-flex app-wrapper">
