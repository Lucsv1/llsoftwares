<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class StockMoviment
{

    public function saveDatasStockMoviment($data)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("INSERT INTO Movimentacao_Estoque (ID_Produto, ID_Usuario, Tipo, Quantidade, Motivo) VALUES (:idProduto, :idUser, :tipo, :quantidade :motivo)");

        $stmt->bindParam(":idProduto", $data['idProduct']);
        $stmt->bindParam(":idUser", $data['idUser']);
        $stmt->bindParam(":tipo", $data['typeStock']);
        $stmt->bindParam(":quantidade", $data['quantityStock']);
        $stmt->bindParam(":motivo", $data['ObservationStock']);

        $stmt->execute();
    }

    public function getDatasStockMoviment()
    {
        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Movimentacao_Estoque");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function delDatasStock($id)
    {
        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("DELETE FROM Produtos WHERE ID_Produto = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();
    }

    public function editDatasProducts($id, $datas)
    {
        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("UPDATE Movimentacao_Estoque SET ID_Produto = :idProduto, ID_Usuario = :idUser, Tipo = :tipo, Quantidade = :quantidade, Motivo = :motivo WHERE ID_Movimentacao = $id");

        $stmt->bindParam(":idProduto", $datas['idProduct']);
        $stmt->bindParam(":idUser", $datas['idUser']);
        $stmt->bindParam(":tipo", $datas['typeStock']);
        $stmt->bindParam(":quantidade", $datas['quantityStock']);
        $stmt->bindParam(":motivo", $datas['ObservationStock']);

        $stmt->execute();
    }

    
    public function getDatasProductsById($id)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Produtos WHERE ID_Produto = $id");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }


}
