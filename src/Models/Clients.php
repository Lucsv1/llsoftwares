<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class Clients
{

    public function saveDatasClients($data)
    {
        $db = new Database();
        $pdo = $db->auth_db();
        $stmt = $pdo->prepare("INSERT INTO Clientes (Nome_completo, Contato, CPF, CEP, Endereco, Email, Observacoes) VALUES (:name, :telepone, :cpf, :cep, :address, :email, :observacoes)");

        $stmt->bindParam(":name", $data['nameClient']);
        $stmt->bindParam(":telepone", $data['telephoneClient']);
        $stmt->bindParam(":cpf", $data['cpfClients']);
        $stmt->bindParam(":cep", $data['cepClients']);
        $stmt->bindParam(":address", $data['addressClients']);
        $stmt->bindParam(":email", $data['emailClients']);
        $stmt->bindParam(":observacoes", $data['observation']);

        $stmt->execute();
    }

    public function getDatasClients()
    {

        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM  Clientes");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function delDatasClients($id)
    {

        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("DELETE FROM Clientes WHERE ID = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();
    }

    public function editDatasClients($id, $datas)
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

    public function getDatasClientsById($id)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Clientes WHERE ID = $id");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
