<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class Products
{


    public function saveDatasProducts($data)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("INSERT INTO Produtos (Nome, Descricao, Preco, Preco_Custo, Quantidade_Estoque) VALUES (:nome, :descricao, :preco, :precoCusto, :quantidade)");

        $stmt->bindParam(":nome", $data['nameProduct']);
        $stmt->bindParam(":descricao", $data['descriptionProduct']);
        $stmt->bindParam(":quantidade", $data['quantityStorage']);
        $stmt->bindParam(":preco", $data['priceProduct']);
        $stmt->bindParam(":precoCusto", $data['priceCost']);

        $stmt->execute();
    }

    public function getDatasProducts()
    {
        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Produtos");

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

        $stmt = $pdo->prepare("DELETE FROM Produtos WHERE ID_Produto = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();

    }

    public function editDatasProducts($id, $datas)
    {
        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("UPDATE Produtos SET Nome = :nome, Descricao = :descricao, Preco = :preco, Preco_Custo = :priceCost,  Quantidade_Estoque = :quantidade, Status = :status WHERE ID_Produto = $id");

        $stmt->bindParam(":nome", $datas['nameProduct']);
        $stmt->bindParam(":descricao", $datas['descriptionProduct']);
        $stmt->bindParam(":preco", $datas['priceProduct']);
        $stmt->bindParam(":priceCost", $datas['priceCost']);
        $stmt->bindParam(":quantidade", $datas['quantityStorage']);
        $stmt->bindParam(":status", $datas['statusProduct']);

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

    public function datasProductsSold($id, $solded){

        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("UPDATE Produtos SET Quantidade_Estoque = :solded WHERE ID_Produto = $id");

        $stmt->bindParam(":solded", $solded);

        $stmt->execute();
    }

}