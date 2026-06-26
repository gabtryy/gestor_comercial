<?php

class Router
{
    public static function dispatch(): void
    {
        $controllerName = $_GET['c'] ?? '';
        $method = $_GET['m'] ?? 'index';

        if ($controllerName === '') {
            if (!empty($_SESSION['usuario'])) {
                header('Location: index.php?c=dashboard&m=index');
            } else {
                header('Location: index.php?c=auth&m=login');
            }
            exit;
        }

        $class = ucfirst(strtolower($controllerName)) . 'Controller';
        $file = __DIR__ . '/../controlador/' . $class . '.php';

        if (!file_exists($file)) {
            http_response_code(404);
            echo 'Controlador no encontrado.';
            return;
        }

        require_once $file;

        if (!class_exists($class) || !method_exists($class, $method)) {
            http_response_code(404);
            echo 'Acción no encontrada.';
            return;
        }

        $controller = new $class();
        $controller->$method();
    }
}
