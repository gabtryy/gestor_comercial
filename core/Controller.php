<?php

class Controller
{
    protected function render(string $view, array $data = [], ?string $layout = null): void
    {
        extract($data, EXTR_SKIP);
        $viewPath = __DIR__ . '/../vista/' . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo 'Vista no encontrada: ' . htmlspecialchars($view);
            return;
        }

        if ($layout !== null) {
            $contentView = $viewPath;
            require __DIR__ . '/../vista/layouts/' . $layout . '.php';
            return;
        }

        require $viewPath;
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function baseUrl(): string
    {
        $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        return rtrim(dirname($script), '/\\') . '/index.php';
    }

    protected function url(string $query = ''): string
    {
        $base = $this->baseUrl();
        return $query !== '' ? $base . '?' . ltrim($query, '?') : $base;
    }

    protected function requireAuth(): void
    {
        if (empty($_SESSION['usuario'])) {
            $this->redirect($this->url('c=auth&m=login'));
        }
    }

    protected function isAuthenticated(): bool
    {
        return !empty($_SESSION['usuario']);
    }

    protected function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
