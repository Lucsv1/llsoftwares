<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class Payments
{
    public function saveDatasPayemnts($data)
    {

        $db = new Database();   
        $pdo = $db->auth_db();  

        $stmt = $pdo->prepare("INSERT INTO Pagamentos (ID_Pedido, Valor_Pago ,Metodo_Pagamento) VALUES (:idPedido, :valorPago ,:metodo)");

        $stmt->bindParam(":idPedido", $data['idOrder']);
        $stmt->bindParam(":valorPago", $data['valuePayment']);
        $stmt->bindParam(":metodo", $data['method']);

        $stmt->execute();

    }

    public function getDatasPaymentsById($id){

        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Pagamentos WHERE ID_Pedido = $id");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
