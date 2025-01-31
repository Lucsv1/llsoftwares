<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class FinancialReport
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->auth_db();
    }

    // Get total revenue for a specific period
    public function getTotalRevenue($startDate = null, $endDate = null)
    {
        $query = "SELECT 
            SUM(CAST(REPLACE(Valor_Total, ',', '.') AS DECIMAL(10,2))) as total_revenue 
            FROM Pedidos 
            WHERE Status = 'Concluído'";

        if ($startDate && $endDate) {
            $query .= " AND Data BETWEEN :start_date AND :end_date";
        }

        $stmt = $this->pdo->prepare($query);

        if ($startDate && $endDate) {
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_revenue'] ?? 0;
    }

    // Get total expenses (based on product costs)
    public function getTotalExpenses($startDate = null, $endDate = null)
    {
        $query = "SELECT 
            SUM(pp.Quantidade * p.Preco_Custo) as total_expenses
            FROM Pedidos_Produtos pp
            JOIN Produtos p ON pp.ID_Produto = p.ID_Produto
            JOIN Pedidos ped ON pp.ID_Pedido = ped.ID_Pedido
            WHERE ped.Status = 'Concluído'";

        if ($startDate && $endDate) {
            $query .= " AND ped.Data BETWEEN :start_date AND :end_date";
        }

        $stmt = $this->pdo->prepare($query);

        if ($startDate && $endDate) {
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_expenses'] ?? 0;
    }

    // Get revenue by payment method
    public function getPaymentMethodBreakdown($startDate = null, $endDate = null)
    {
        $query = "SELECT 
            p.Metodo_Pagamento, 
            COUNT(*) as transaction_count,
            SUM(CAST(REPLACE(ped.Valor_Total, ',', '.') AS DECIMAL(10,2))) as total_amount
            FROM Pagamentos p
            JOIN Pedidos ped ON p.ID_Pedido = ped.ID_Pedido
            WHERE ped.Status = 'Concluído'";

        if ($startDate && $endDate) {
            $query .= " AND p.Data BETWEEN :start_date AND :end_date";
        }

        $query .= " GROUP BY p.Metodo_Pagamento";

        $stmt = $this->pdo->prepare($query);

        if ($startDate && $endDate) {
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get top-selling products
    public function getTopProducts($limit = 5)
    {
        $query = "SELECT 
            p.Nome as product_name, 
            SUM(pp.Quantidade) as total_quantity,
            SUM(CAST(pp.Valor_Total AS DECIMAL(10,2))) as total_revenue
            FROM Pedidos_Produtos pp
            JOIN Produtos p ON pp.ID_Produto = p.ID_Produto
            JOIN Pedidos ped ON pp.ID_Pedido = ped.ID_Pedido
            WHERE ped.Status = 'Concluído'
            GROUP BY p.ID_Produto
            ORDER BY total_quantity DESC
            LIMIT :limit";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get monthly revenue trend
    public function getMonthlyRevenueTrend($months = 6)
    {
        $query = "SELECT 
            DATE_FORMAT(Data, '%Y-%m') as month,
            SUM(CAST(REPLACE(Valor_Total, ',', '.') AS DECIMAL(10,2))) as total_revenue
            FROM Pedidos
            WHERE Status = 'Concluído'
            AND Data >= DATE_SUB(CURDATE(), INTERVAL :months MONTH)
            GROUP BY month
            ORDER BY month";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':months', $months, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}