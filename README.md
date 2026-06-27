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

## Próximos módulos

Los enlaces del menú lateral (Productos, Clientes, Facturas, etc.) están preparados para implementación futura.
