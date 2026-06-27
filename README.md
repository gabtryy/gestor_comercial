# Sistema Papelería — MVC PHP

Aplicación web en PHP (patrón MVC) con login y dashboard para el sistema de papelería.

## Requisitos

- XAMPP (Apache + MySQL + PHP 8.x)
- Base de datos `sistema_papeleria` importada

## Instalación

1. **Importar la base de datos**  
   En phpMyAdmin, importe el archivo `sistema_papeleria.sql` (crea la BD y las tablas).

2. **Crear usuario administrador**  
   Ejecute en phpMyAdmin el script [`database/seed_admin.sql`](database/seed_admin.sql).

3. **Configurar conexión** (si es necesario)  
   Edite [`config/database.php`](config/database.php) con host, usuario y contraseña de MySQL.

4. **Abrir en el navegador**  
   `http://localhost/papeleria/`

## Credenciales de prueba

| Campo      | Valor     |
|-----------|-----------|
| Usuario   | `admin`   |
| Contraseña| `admin123`|

## Estructura MVC

```
papeleria/
├── index.php          # Front controller
├── config/            # Configuración BD
├── core/              # Router, Controller, Model
├── controlador/       # Lógica de control
├── modelo/            # Acceso a datos
├── vista/             # Plantillas HTML
└── assets/            # CSS
```

## Rutas

| URL | Descripción |
|-----|-------------|
| `index.php` | Redirige a login o dashboard |
| `?c=auth&m=login` | Iniciar sesión |
| `?c=auth&m=logout` | Cerrar sesión |
| `?c=dashboard&m=index` | Panel principal (requiere sesión) |
| `?c=productos&m=index` | Listado de productos (requiere sesión) |
| `?c=productos&m=guardar` | Crear producto (POST) |
| `?c=productos&m=eliminar` | Eliminar producto (POST) |

## Cómo funciona el sistema (ejemplo: módulo Productos)

La aplicación sigue el patrón **MVC** con un **front controller** (`index.php`). Todas las peticiones pasan por ahí; el **Router** interpreta los parámetros `c` (controlador) y `m` (método/acción) y delega al controlador correspondiente.

```
Navegador → index.php → Router → Controlador → Modelo → MySQL
                                      ↓
                                    Vista → Layout → HTML
```

| Capa | Carpeta | Responsabilidad |
|------|---------|-----------------|
| Entrada | `index.php` | Sesión, autoload, despacho al router |
| Núcleo | `core/` | Router, Controller base, Model base |
| Controlador | `controlador/` | Lógica HTTP, validación, autenticación |
| Modelo | `modelo/` | Consultas SQL con PDO |
| Vista | `vista/` | HTML + Bootstrap |
| Config | `config/` | Conexión a MySQL |

### Punto de entrada

`index.php` inicia la sesión PHP, registra un autoload para cargar clases desde `core/`, `controlador/` y `modelo/`, y llama a `Router::dispatch()`.

### Enrutamiento

El router convierte `c=productos` en la clase `ProductosController` y ejecuta el método indicado en `m`:

| URL | Controlador | Método | Resultado |
|-----|-------------|--------|-----------|
| `index.php` | — | — | Redirige a login o dashboard |
| `?c=productos&m=index` | `ProductosController` | `index()` | Listado de productos |
| `?c=productos&m=guardar` | `ProductosController` | `guardar()` | Crear producto (POST) |
| `?c=productos&m=eliminar` | `ProductosController` | `eliminar()` | Borrar producto (POST) |

Convención: `c=productos` → archivo `controlador/ProductosController.php`; `m=index` → método público `index()`.

### Autenticación

Los módulos protegidos llaman a `requireAuth()` en su constructor. Si no hay `$_SESSION['usuario']`, redirige a `?c=auth&m=login`. Tras un login correcto, `AuthController` guarda id, nombre y rol del usuario en sesión.

### Flujo del módulo Productos

**Ver listado** (`GET ?c=productos&m=index`):

1. `ProductosController::index()` verifica sesión.
2. `ProductoModel::listar()` ejecuta `SELECT` sobre la tabla `productos`.
3. El controlador pasa `$productos` y datos de sesión a la vista con `render('productos/index', ..., 'main')`.
4. La vista calcula estadísticas (total, stock bajo, sin stock, valor inventario) y muestra la tabla.

**Crear producto** (`POST ?c=productos&m=guardar`):

1. El formulario del modal envía POST al controlador.
2. `validarFormulario()` comprueba nombre, precio, stock, código de barras único, etc.
3. Si hay error, guarda mensaje y valores en `$_SESSION` y redirige (patrón **Post-Redirect-Get**).
4. Si es válido, `ProductoModel::crear()` hace `INSERT` y redirige con mensaje de éxito.

**Eliminar producto** (`POST ?c=productos&m=eliminar`):

1. Recibe `id_producto` por POST.
2. `ProductoModel::eliminar()` ejecuta `DELETE`.
3. Si el producto está referenciado en facturas o apartados, MySQL bloquea el borrado por claves foráneas y se muestra un error.

### Capa de datos

`Model` base proporciona una conexión PDO singleton leyendo `config/database.php`. Cada modelo (`ProductoModel`, `UsuarioModel`, etc.) extiende `Model` y encapsula las consultas SQL.

Tabla `productos`:

| Campo | Tipo | Notas |
|-------|------|-------|
| `id_producto` | int | PK |
| `codigo_barras` | varchar(50) | Opcional |
| `nombre` | varchar(150) | Obligatorio |
| `descripcion` | text | Opcional |
| `precio_venta` | decimal | Obligatorio |
| `stock` | int | Default 0 |
| `stock_minimo` | int | Default 5 |

### Vistas y layout

`Controller::render()` usa `extract()` para inyectar variables en la vista. Con layout `main`, la página se compone así:

```
header.php   → navbar, Bootstrap, usuario logueado
sidebar.php  → menú lateral (marca activo según $_GET['c'])
[vista]      → contenido del módulo (ej. productos/index.php)
footer.php   → scripts
```

Los mensajes de éxito/error tras un POST se guardan en `$_SESSION`, se leen en la siguiente petición GET y se eliminan (flash messages).

### Añadir un nuevo módulo

Cualquier módulo nuevo sigue el mismo patrón que Productos:

1. `modelo/XxxModel.php` — consultas SQL.
2. `controlador/XxxController.php` — extiende `Controller`, usa `requireAuth()`, valida POST, llama al modelo.
3. `vista/xxx/index.php` — HTML del módulo.
4. Enlace en `vista/layouts/sidebar.php`.

## Próximos módulos

Productos ya está implementado. Pendientes: Clientes, Facturas, Apartados, Servicios y Empleados (enlaces deshabilitados en el menú lateral).
