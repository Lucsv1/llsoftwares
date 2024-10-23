<?php

namespace Admin\Project\Config;

use PDO;
use PDOException;

class Database
{
    private $dsn;
    private $user;
    private $password;

    public function __construct() {
        $this->setDsn('mysql:host=127.0.0.1;dbname=projeto_futuro');
        $this->setUser('root');
        $this->setPassword('');
    }

    /**
     * Get the value of dsn
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * Set the value of dsn
     *
     * @return  self
     */
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function auth_db()
    {
        $dns = $this->getDsn();
        $username = $this->getUser();
        $password = $this->getPassword();

        $pdo = new PDO($dns, $username);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->create_tables($pdo);

        return $pdo;
    }

    private function create_tables($pdo)
    {

        $sql_users = "SELECT 1 FROM Admin LIMIT 1";
        $sql_clientes = "SELECT 1 FROM Clients LIMIT 1";
        $sql_orders = "SELECT 1 FROM Orders LIMIT 1";
        $sql_products = "SELECT 1 FROM Products LIMIT 1";
        $sql_payments = "SELECT 1 FROM Payments LIMIT 1";
        $sql_orders_products = "SELECT 1 FROM Orders_Products LIMIT 1";

        try {
            $pdo->query($sql_users);
            $pdo->query($sql_clientes);
            $pdo->query($sql_orders);
            $pdo->query($sql_products);
            $pdo->query($sql_payments);
            $pdo->query($sql_orders_products);
        } catch (PDOException $e) {

            $sql_users = "CREATE TABLE Users (
            ID INT PRIMARY KEY,
            Username VARCHAR(255),
            Password VARCHAR(255),
            Role JSON,
            Active TINYINT(1)
            )";

            $this->create_root_user($pdo, "Admin", '$2y$10$mN2/N/fRjJBCrdifyLCL3OPAp9R/y1WIn7dAo3e/8e.qqEbE6jOhS', json_encode(array("role" => "Admin")), 1);

            $pdo->exec($sql_users);

            $sql_clientes = "CREATE TABLE Clientes (
            ID INT PRIMARY KEY,
            Nome_Completo VARCHAR(100) NOT NULL,
            Contato VARCHAR(15),
            CPF VARCHAR(11),
            CEP VARCHAR(8),
            Endereco VARCHAR(255),
            Email VARCHAR(100)
            );";

            $pdo->exec($sql_clientes);

            $sql_orders = "CREATE TABLE Pedidos (
            ID_Pedido INT PRIMARY KEY,
            ID_Cliente INT,
            Data DATE NOT NULL,
            Valor_Total DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (ID_Cliente) REFERENCES Clientes(ID)
            );";

            $pdo->exec($sql_orders);

            $sql_products = "CREATE TABLE Produtos (
            ID_Produto INT PRIMARY KEY,
            Nome VARCHAR(100) NOT NULL,
            Preco DECIMAL(10, 2) NOT NULL
            );";

            $pdo->exec($sql_products);

            $sql_payments = "CREATE TABLE Pagamentos (
            ID_Pagamento INT PRIMARY KEY,
            ID_Pedido INT,
            Data DATE NOT NULL,
            Metodo_Pagamento VARCHAR(50) NOT NULL,
            FOREIGN KEY (ID_Pedido) REFERENCES Pedidos(ID_Pedido)
            );";

            $pdo->exec($sql_payments);

            $sql_orders_products = "CREATE TABLE Pedidos_Produtos (
            ID_Pedido INT,
            ID_Produto INT,
            Quantidade INT NOT NULL,
            PRIMARY KEY (ID_Pedido, ID_Produto),
            FOREIGN KEY (ID_Pedido) REFERENCES Pedidos(ID_Pedido),
            FOREIGN KEY (ID_Produto) REFERENCES Produtos(ID_Produto)
            );";

            $pdo->exec($sql_orders_products);
        }
    }

    private function create_root_user($pdo, $username, $password, $role, $active){
        $sql_create = "INSERT INTO Users (Username, Password, Role, Active) VALUES (:username, :password, :role, :active)";
        $stmt = $pdo->prepare($sql_create);

        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":role", $role);
        $stmt->bindValue(":active", $active);
        
        $stmt->execute();

        return $pdo->lasInsertId();
    }
}
