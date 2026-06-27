<?php

class UsuarioModel extends Model
{
    public function buscarPorUsername(string $username): ?array
    {
        $sql = 'SELECT u.id_usuario, u.username, u.password_hash, u.id_empleado,
                       e.nombre, e.rol, e.activo
                FROM usuarios u
                INNER JOIN empleados e ON e.id_empleado = u.id_empleado
                WHERE u.username = :username
                LIMIT 1';

        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function actualizarUltimoLogin(int $idUsuario): void
    {
        $sql = 'UPDATE usuarios SET ultimo_login = NOW() WHERE id_usuario = :id';
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute(['id' => $idUsuario]);
    }
}
