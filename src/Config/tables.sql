CREATE TABLE
    `Users` (
        ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        Username VARCHAR(255),
        Password VARCHAR(255),
        Role JSON,
        Active TINYINT (1)
    );
    
CREATE TABLE `Users` (
    ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Nome_Completo VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Role JSON NOT NULL,
    Active TINYINT(1) DEFAULT 1,
    Created_At DATETIME DEFAULT current_timestamp(),
    Last_Login DATETIME
);

CREATE TABLE `Clientes` (
    ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Nome_Completo VARCHAR(100) NOT NULL,
    Contato VARCHAR(15),
    CPF VARCHAR(14),
    CEP VARCHAR(20),
    Endereco VARCHAR(255),
    Numero VARCHAR(10),
    Complemento VARCHAR(100),
    Bairro VARCHAR(100),
    Cidade VARCHAR(100),
    Estado VARCHAR(2),
    Email VARCHAR(100),
    Data_Nascimento DATE,
    Observacoes TEXT,
    Status ENUM('Ativo', 'Inativo', 'Bloqueado') DEFAULT 'Ativo',
    Created_At DATETIME DEFAULT current_timestamp(),
    Updated_At DATETIME ON UPDATE current_timestamp()
);

CREATE TABLE `Produtos` (
    ID_Produto INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Nome VARCHAR(100) NOT NULL,
    Descricao TEXT,
    Preco DECIMAL(10, 2) NOT NULL,
    Preco_Custo DECIMAL(10, 2),
    Quantidade_Estoque INT DEFAULT 0,
    Estoque_Minimo INT DEFAULT 5,
    Codigo_Barras VARCHAR(50),
    Tipo ENUM('Produto', 'Serviço') DEFAULT 'Produto',
    Status ENUM('Ativo', 'Inativo', 'Sem_Estoque') DEFAULT 'Ativo',
    Created_At DATETIME DEFAULT current_timestamp(),
    Updated_At DATETIME ON UPDATE current_timestamp()
);

CREATE TABLE `Servicos` (
    ID_Servico INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Nome VARCHAR(100) NOT NULL,
    Descricao TEXT,
    Preco DECIMAL(10, 2) NOT NULL,
    Duracao_Minutos INT,
    Status ENUM('Ativo', 'Inativo') DEFAULT 'Ativo',
    Created_At DATETIME DEFAULT current_timestamp(),
    Updated_At DATETIME ON UPDATE current_timestamp()
);

CREATE TABLE `Agendamentos` (
    ID_Agendamento INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ID_Cliente INT,
    ID_Servico INT,
    ID_Usuario INT,
    Data_Agendamento DATE NOT NULL,
    Hora_Inicio TIME NOT NULL,
    Hora_Fim TIME NOT NULL,
    Status ENUM('Agendado', 'Confirmado', 'Cancelado', 'Concluído') DEFAULT 'Agendado',
    Observacoes TEXT,
    Created_At DATETIME DEFAULT current_timestamp(),
    FOREIGN KEY (ID_Cliente) REFERENCES Clientes(ID),
    FOREIGN KEY (ID_Servico) REFERENCES Servicos(ID_Servico),
    FOREIGN KEY (ID_Usuario) REFERENCES Users(ID)
);

CREATE TABLE `Pedidos` (
    ID_Pedido INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ID_Cliente INT,
    ID_Usuario INT,
    Tipo ENUM('Venda', 'Orçamento') DEFAULT 'Venda',
    Status ENUM('Pendente', 'Aprovado', 'Cancelado', 'Concluído') DEFAULT 'Pendente',
    Data DATETIME DEFAULT current_timestamp(),
    Valor_Subtotal DECIMAL(10, 2) NOT NULL,
    Valor_Desconto DECIMAL(10, 2) DEFAULT 0,
    Valor_Total DECIMAL(10, 2) NOT NULL,
    Observacoes TEXT,
    FOREIGN KEY (ID_Cliente) REFERENCES Clientes(ID),
    FOREIGN KEY (ID_Usuario) REFERENCES Users(ID)
);

CREATE TABLE `Pagamentos` (
    ID_Pagamento INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ID_Pedido INT,
    Data DATE NOT NULL,
    Valor_Pago DECIMAL(10, 2) NOT NULL,
    Metodo_Pagamento ENUM('Dinheiro', 'Cartão de Crédito', 'Cartão de Débito', 'PIX', 'Boleto') NOT NULL,
    Parcelas INT DEFAULT 1,
    Status ENUM('Pendente', 'Aprovado', 'Cancelado') DEFAULT 'Pendente',
    Comprovante VARCHAR(255),
    FOREIGN KEY (ID_Pedido) REFERENCES Pedidos(ID_Pedido)
);

CREATE TABLE `Pedidos_Produtos` (
    ID_Pedido INT,
    ID_Produto INT,
    Quantidade INT NOT NULL,
    Preco_Unitario DECIMAL(10, 2) NOT NULL,
    Desconto DECIMAL(10, 2) DEFAULT 0,
    Valor_Total DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (ID_Pedido, ID_Produto),
    FOREIGN KEY (ID_Pedido) REFERENCES Pedidos(ID_Pedido),
    FOREIGN KEY (ID_Produto) REFERENCES Produtos(ID_Produto)
);

CREATE TABLE `Pedidos_Servicos` (
    ID_Pedido INT,
    ID_Servico INT,
    Preco_Unitario DECIMAL(10, 2) NOT NULL,
    Desconto DECIMAL(10, 2) DEFAULT 0,
    Valor_Total DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (ID_Pedido, ID_Servico),
    FOREIGN KEY (ID_Pedido) REFERENCES Pedidos(ID_Pedido),
    FOREIGN KEY (ID_Servico) REFERENCES Servicos(ID_Servico)
);

CREATE TABLE `Movimentacao_Estoque` (
    ID_Movimentacao INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ID_Produto INT,
    ID_Usuario INT,
    Tipo ENUM('Entrada', 'Saída', 'Ajuste') NOT NULL,
    Quantidade INT NOT NULL,
    Data DATETIME DEFAULT current_timestamp(),
    Motivo TEXT,
    FOREIGN KEY (ID_Produto) REFERENCES Produtos(ID_Produto),
    FOREIGN KEY (ID_Usuario) REFERENCES Users(ID)
);