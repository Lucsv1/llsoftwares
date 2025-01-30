<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class OrdersProducts
{
    public function saveDatasOrdersPorducts($data)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("INSERT INTO Pedidos_Produtos (ID_Pedido,ID_Produto, Quantidade, Preco_Unitario, Valor_Total) VALUES (:idPedido,:idProduto, :quantidade, :valor_unitario ,:valor_total)");

        $stmt->bindParam(":idPedido", $data['idPedido']);
        $stmt->bindParam(":idProduto", $data['idProdutos']);
        $stmt->bindParam(":quantidade", $data['quantidade']);
        $stmt->bindParam(":valor_unitario", $data['valorUnitario']);
        $stmt->bindParam(":valor_total", $data['valorTotal']);

        $stmt->execute();
    }

    public function getDatasOrdersPorducts()
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Pedidos_Produtos");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getDatasOrdersProductsById($id)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Pedidos_Produtos WHERE ID_Pedido = $id");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
