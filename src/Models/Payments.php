<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;

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
}
