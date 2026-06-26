<?php

class DashboardModel extends Model
{
    public function obtenerMetricas(): array
    {
        $pdo = self::getConnection();

        $ventasHoy = (float) ($pdo->query(
            "SELECT COALESCE(SUM(monto_total), 0) FROM factura
             WHERE DATE(fecha_facturacion) = CURDATE()"
        )->fetchColumn() ?: 0);

        $facturasHoy = (int) $pdo->query(
            "SELECT COUNT(*) FROM factura
             WHERE DATE(fecha_facturacion) = CURDATE()"
        )->fetchColumn();

        $apartadosPendientes = (int) $pdo->query(
            "SELECT COUNT(*) FROM apartados WHERE estado = 'pendiente'"
        )->fetchColumn();

        $stockBajo = (int) $pdo->query(
            'SELECT COUNT(*) FROM productos WHERE stock <= stock_minimo'
        )->fetchColumn();

        $totalProductos = (int) $pdo->query(
            'SELECT COUNT(*) FROM productos'
        )->fetchColumn();

        $totalClientes = (int) $pdo->query(
            'SELECT COUNT(*) FROM clientes'
        )->fetchColumn();

        return [
            'ventasHoy'           => $ventasHoy,
            'facturasHoy'         => $facturasHoy,
            'apartadosPendientes' => $apartadosPendientes,
            'stockBajo'           => $stockBajo,
            'totalProductos'      => $totalProductos,
            'totalClientes'       => $totalClientes,
        ];
    }

    public function obtenerUltimasFacturas(int $limite = 5): array
    {
        $sql = 'SELECT f.id_factura, f.monto_total, f.fecha_facturacion, f.metodo_pago,
                       COALESCE(c.nombre, "Sin cliente") AS cliente,
                       e.nombre AS empleado
                FROM factura f
                LEFT JOIN clientes c ON c.id_cliente = f.id_cliente
                INNER JOIN empleados e ON e.id_empleado = f.id_empleado
                ORDER BY f.fecha_facturacion DESC
                LIMIT :limite';

        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
