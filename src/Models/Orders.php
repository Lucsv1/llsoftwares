<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class Orders
{

    public function saveDatasOrders($data)
    {

        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("INSERT INTO Pedidos (ID_Cliente, Valor) VALUES (:id_clientes, :valor)");

        $stmt->bindParam(":id_clientes", $data['idClient']);
        $stmt->bindParam(":valor", $data['price']);

        $stmt->execute();
    }

    public function getDatasOrders($data)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Pedidos");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
