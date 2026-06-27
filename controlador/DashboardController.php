<?php

class DashboardController extends Controller
{
    private DashboardModel $dashboardModel;

    public function __construct()
    {
        $this->requireAuth();
        $this->dashboardModel = new DashboardModel();
    }

    public function index(): void
    {
        $metricas = $this->dashboardModel->obtenerMetricas();
        $ultimasFacturas = $this->dashboardModel->obtenerUltimasFacturas();

        $this->render('dashboard/index', array_merge($metricas, [
            'ultimasFacturas' => $ultimasFacturas,
            'usuario'         => $_SESSION['usuario'],
            'pageTitle'       => 'Dashboard',
        ]), 'main');
    }
}
