-- Ejecutar DESPUÉS de importar sistema_papeleria.sql
-- Credenciales de prueba: usuario admin / contraseña admin123
-- Cambiar la contraseña en producción.

USE sistema_papeleria;

INSERT INTO empleados (nombre, documento_identidad, rol, activo)
VALUES ('Administrador Sistema', 'V-00000001', 'administrador', 1);

INSERT INTO usuarios (id_empleado, username, password_hash)
VALUES (
    LAST_INSERT_ID(),
    'admin',
    '$2y$10$F7nn6C3kdVLkLAPCWUmlResWbP8fCH7hnXQfuH47O4SFMJBJ.XVq2'
);
