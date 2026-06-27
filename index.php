<?php

session_start();

define('BASE_PATH', __DIR__);

spl_autoload_register(function (string $class): void {
    $paths = [
        BASE_PATH . '/core/' . $class . '.php',
        BASE_PATH . '/controlador/' . $class . '.php',
        BASE_PATH . '/modelo/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Router.php';

Router::dispatch();

<?php

session_start();

define('BASE_PATH', __DIR__);

spl_autoload_register(function (string $class): void {
    $paths = [
        BASE_PATH . '/core/' . $class . '.php',
        BASE_PATH . '/controlador/' . $class . '.php',
        BASE_PATH . '/modelo/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Router.php';

Router::dispatch();
