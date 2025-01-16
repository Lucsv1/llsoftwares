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

        $stmt = $pdo->prepare("INSERT INTO Pedidos (ID_Cliente) VALUES (:id_clientes)");

        $stmt->bindParam(":id_clientes", $data['idClient']);

        $stmt->execute();

        return $pdo->lastInsertId();
    }

    public function getDatasOrders()
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

    public function delDatasProducts($id)
    {
        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("DELETE FROM Pedidos WHERE ID_Pedido = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();
    }

    public function editDatasOrders($id, $datas)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("UPDATE Pedidos SET  Valor = :valor");

        $stmt->bindParam(":valor", $datas['price']);

        $stmt->execute();
    }

    public function getDatasOrdersById($id){
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Pedidos WHERE ID_Pedido = $id");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
