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

        $stmt = $pdo->prepare("INSERT INTO Produtos (Nome, Descricao, Preco, Quantidade_Estoque) VALUES (:nome, :descricao, :preco, :quantidade)");

        $stmt->bindParam(":nome", $data['nameProduct']);
        $stmt->bindParam(":descricao", $data['descriptionProduct']);
        $stmt->bindParam(":quantidade", $data['quantityStorage']);
        $stmt->bindParam(":preco", $data['priceProduct']);

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

        $stmt = $pdo->prepare("UPDATE Clientes SET Nome_completo = :name, Contato = :telephone, CPF = :cpf, CEP = :cep, Endereco = :address, Email = :email WHERE ID = $id");

        $stmt->bindParam(":name", $datas['nameClient']);
        $stmt->bindParam(":telephone", $datas['telephoneClient']);
        $stmt->bindParam(":cpf", $datas['cpfClients']);
        $stmt->bindParam(":cep", $datas['cepClients']);
        $stmt->bindParam(":address", $datas['addressClients']);
        $stmt->bindParam(":email", $datas['emailClients']);

        $stmt->execute();
    }

}