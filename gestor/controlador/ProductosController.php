<?php

class ProductosController extends Controller
{
    private ProductoModel $productoModel;

    public function __construct()
    {
        $this->requireAuth();
        $this->productoModel = new ProductoModel();
    }

    public function index(): void
    {
        $productos = $this->productoModel->listar();

        $exito = $_SESSION['exito'] ?? null;
        $error = $_SESSION['error'] ?? null;
        $formulario = $_SESSION['formulario_producto'] ?? [];
        unset($_SESSION['exito'], $_SESSION['error'], $_SESSION['formulario_producto']);

        $this->render('productos/index', [
            'productos'   => $productos,
            'usuario'     => $_SESSION['usuario'],
            'pageTitle'   => 'Productos',
            'exito'       => $exito,
            'error'       => $error,
            'formulario'  => $formulario,
            'abrirModal'  => !empty($error) || !empty($formulario),
        ], 'main');
    }

    public function guardar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect($this->url('c=productos&m=index'));
        }

        $datos = $this->validarFormulario($_POST);

        if (isset($datos['error'])) {
            $_SESSION['error'] = $datos['error'];
            $_SESSION['formulario_producto'] = $datos['valores'];
            $this->redirect($this->url('c=productos&m=index'));
        }

        try {
            $this->productoModel->crear($datos['valores']);
            $_SESSION['exito'] = 'Producto registrado correctamente.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'No se pudo guardar el producto. Verifique los datos.';
            $_SESSION['formulario_producto'] = $datos['valores'];
        }

        $this->redirect($this->url('c=productos&m=index'));
    }

    public function eliminar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect($this->url('c=productos&m=index'));
        }

        $id = (int) ($_POST['id_producto'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'Producto no válido.';
            $this->redirect($this->url('c=productos&m=index'));
        }

        try {
            if ($this->productoModel->eliminar($id)) {
                $_SESSION['exito'] = 'Producto eliminado correctamente.';
            } else {
                $_SESSION['error'] = 'El producto no existe o ya fue eliminado.';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'No se puede eliminar: el producto está en facturas o apartados.';
        }

        $this->redirect($this->url('c=productos&m=index'));
    }

    private function validarFormulario(array $post): array
    {
        $valores = [
            'codigo_barras' => trim($post['codigo_barras'] ?? ''),
            'nombre'        => trim($post['nombre'] ?? ''),
            'descripcion'   => trim($post['descripcion'] ?? ''),
            'precio_venta'  => trim($post['precio_venta'] ?? ''),
            'stock'         => trim($post['stock'] ?? '0'),
            'stock_minimo'  => trim($post['stock_minimo'] ?? '5'),
        ];

        if ($valores['nombre'] === '') {
            return ['error' => 'El nombre del producto es obligatorio.', 'valores' => $valores];
        }

        if (mb_strlen($valores['nombre']) > 150) {
            return ['error' => 'El nombre no puede superar 150 caracteres.', 'valores' => $valores];
        }

        if ($valores['precio_venta'] === '' || !is_numeric($valores['precio_venta']) || (float) $valores['precio_venta'] < 0) {
            return ['error' => 'Ingrese un precio de venta válido.', 'valores' => $valores];
        }

        if (!ctype_digit($valores['stock']) || (int) $valores['stock'] < 0) {
            return ['error' => 'El stock debe ser un número entero mayor o igual a 0.', 'valores' => $valores];
        }

        if (!ctype_digit($valores['stock_minimo']) || (int) $valores['stock_minimo'] < 0) {
            return ['error' => 'El stock mínimo debe ser un número entero mayor o igual a 0.', 'valores' => $valores];
        }

        if ($valores['codigo_barras'] !== '' && mb_strlen($valores['codigo_barras']) > 50) {
            return ['error' => 'El código de barras no puede superar 50 caracteres.', 'valores' => $valores];
        }

        if ($valores['codigo_barras'] !== '' && $this->productoModel->existeCodigoBarras($valores['codigo_barras'])) {
            return ['error' => 'Ya existe un producto con ese código de barras.', 'valores' => $valores];
        }

        return [
            'valores' => [
                'codigo_barras' => $valores['codigo_barras'] !== '' ? $valores['codigo_barras'] : null,
                'nombre'        => $valores['nombre'],
                'descripcion'   => $valores['descripcion'] !== '' ? $valores['descripcion'] : null,
                'precio_venta'  => round((float) $valores['precio_venta'], 2),
                'stock'         => (int) $valores['stock'],
                'stock_minimo'  => (int) $valores['stock_minimo'],
            ],
        ];
    }
}
