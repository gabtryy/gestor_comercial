<?php

class ProductoModel extends Model
{
    public function listar(): array
    {
        $sql = 'SELECT id_producto, codigo_barras, nombre, descripcion, precio_venta, stock, stock_minimo
                FROM productos
                ORDER BY nombre';

        return self::getConnection()->query($sql)->fetchAll();
    }

    public function crear(array $datos): int
    {
        $sql = 'INSERT INTO productos (codigo_barras, nombre, descripcion, precio_venta, stock, stock_minimo)
                VALUES (:codigo_barras, :nombre, :descripcion, :precio_venta, :stock, :stock_minimo)';

        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([
            'codigo_barras' => $datos['codigo_barras'],
            'nombre'        => $datos['nombre'],
            'descripcion'   => $datos['descripcion'],
            'precio_venta'  => $datos['precio_venta'],
            'stock'         => $datos['stock'],
            'stock_minimo'  => $datos['stock_minimo'],
        ]);

        return (int) self::getConnection()->lastInsertId();
    }

    public function existeCodigoBarras(string $codigo): bool
    {
        $sql = 'SELECT COUNT(*) FROM productos WHERE codigo_barras = :codigo';
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute(['codigo' => $codigo]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function eliminar(int $id): bool
    {
        $sql = 'DELETE FROM productos WHERE id_producto = :id';
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
