<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class Orders{

    public function saveDatasOrders($id_client, $data){
        
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("INSERT INTO Pedidos (ID_Cliente, Valor) VALUES (:id_clientes, :valor)");

        $stmt->bindParam(":id_clientes", $id_client);
        $stmt->bindParam(":valor", $data['price']);

        $stmt->execute();

    }

}