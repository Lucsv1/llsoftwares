CREATE TABLE
    `Users` (
        ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        Username VARCHAR(255),
        Password VARCHAR(255),
        Role JSON,
        Active TINYINT (1)
    );
    
CREATE TABLE
    `Clientes` (
        ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        Nome_Completo VARCHAR(100) NOT NULL,
        Contato VARCHAR(15),
        CPF VARCHAR(11),
        CEP VARCHAR(8),
        Endereco VARCHAR(255),
        Email VARCHAR(100)
    );

CREATE TABLE
    `Pedidos` (
        ID_Pedido INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        ID_Cliente INT,
        Data DATE NOT NULL,
        Valor_Total DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (ID_Cliente) REFERENCES Clientes (ID)
    );

CREATE TABLE
    `Produtos` (
        ID_Produto INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        Nome VARCHAR(100) NOT NULL,
        Preco DECIMAL(10, 2) NOT NULL
    );

CREATE TABLE
    `Pagamentos` (
        ID_Pagamento INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        ID_Pedido INT,
        Data DATE NOT NULL,
        Metodo_Pagamento VARCHAR(50) NOT NULL,
        FOREIGN KEY (ID_Pedido) REFERENCES Pedidos (ID_Pedido)
    );

CREATE TABLE
    `Pedidos_Produtos` (
        ID_Pedido INT,
        ID_Produto INT,
        Quantidade INT NOT NULL,
        PRIMARY KEY (ID_Pedido, ID_Produto),
        FOREIGN KEY (ID_Pedido) REFERENCES Pedidos (ID_Pedido),
        FOREIGN KEY (ID_Produto) REFERENCES Produtos (ID_Produto)
    );