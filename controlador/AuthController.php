<?php

class AuthController extends Controller
{
    private UsuarioModel $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect($this->url('c=dashboard&m=index'));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->procesarLogin();
            return;
        }

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $this->render('auth/login', ['error' => $error]);
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
        $this->redirect($this->url('c=auth&m=login'));
    }

    private function procesarLogin(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $_SESSION['error'] = 'Usuario y contraseña son obligatorios.';
            $this->redirect($this->url('c=auth&m=login'));
        }

        $usuario = $this->usuarioModel->buscarPorUsername($username);

        if (
            !$usuario
            || !(int) $usuario['activo']
            || !password_verify($password, $usuario['password_hash'])
        ) {
            $_SESSION['error'] = 'Credenciales incorrectas. Intente de nuevo.';
            $this->redirect($this->url('c=auth&m=login'));
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id_usuario'  => (int) $usuario['id_usuario'],
            'id_empleado' => (int) $usuario['id_empleado'],
            'username'    => $usuario['username'],
            'nombre'      => $usuario['nombre'],
            'rol'         => $usuario['rol'],
        ];

        $this->usuarioModel->actualizarUltimoLogin((int) $usuario['id_usuario']);

        $this->redirect($this->url('c=dashboard&m=index'));
    }
}
