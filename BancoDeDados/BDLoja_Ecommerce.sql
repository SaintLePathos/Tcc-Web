/* MERLoja_Ecommerce: */
USE master
IF EXISTS (SELECT * FROM sys.databases WHERE name = 'Loja_Ecommerce')
BEGIN
    DROP DATABASE Loja_Ecommerce;
END
GO
CREATE DATABASE Loja_Ecommerce
go
USE Loja_Ecommerce
go
CREATE TABLE Endereco_Cliente  (
    Id_Endereco_Cliente INT PRIMARY KEY IDENTITY,
    Id_Cliente INT,
    Municipio_Cliente VARCHAR(50),
    Estado_Cliente VARCHAR(50),
    Numero_Cliente INT,
    Rua_Cliente VARCHAR(50),
    CEP_Cliente INT,
    Referencia_Cliente VARCHAR(100),
    Complemento_Cliente VARCHAR(50)
);
go
CREATE TABLE Pedido  (
    Id_Pedido INT PRIMARY KEY IDENTITY,
    Id_Cliente INT,
    Valor_Pedido DECIMAL(10,2),
    Data_Envio_Pedido DATE,
    Data_Entrega_Pedido DATE
);
go
CREATE TABLE Produto  (
    Id_Produto INT PRIMARY KEY IDENTITY,
    Id_Fornecedor INT,

    Nome_Produto VARCHAR(50),
    Img_Produto VARCHAR(50),
    Descricao_Produto VARCHAR(500),
    Valor_Produto DECIMAL(10,2),
    Peso_Produto DECIMAL(10,2),
    Desconto_Produto DECIMAL(10,2),
    Tamanho_Produto VARCHAR(10),
    Quantidade_Produto INT,
    Tecido_Produto VARCHAR(50),
    Cor_Produto VARCHAR(50)
);
go
CREATE TABLE Produto_Pedido  (
    Id_Produto INT,
    Id_Pedido INT,
    Quantidade_Pedido INT,
	Valor_Produto DECIMAL(10,2),
	Data_Pedido DATE
    PRIMARY KEY (Id_Produto, Id_Pedido)
);
go
CREATE TABLE Cliente  (
    Id_Cliente INT PRIMARY KEY IDENTITY,
    CPF_Cliente VARCHAR(14)  UNIQUE,
    Nome_Cliente VARCHAR(50)  ,
    Usuario_Cliente VARCHAR(50) ,
    Email_Cliente VARCHAR(50) UNIQUE ,
    Senha_Cliente VARCHAR(255),
    Telefone_Cliente VARCHAR(15),
    Img_Perfil_Cliente VARCHAR(50)
);
go
CREATE TABLE Fornecedor  (
    Id_Fornecedor INT PRIMARY KEY IDENTITY,
    CNPJ_Fornecedor VARCHAR(14),
    Nome_Fornecedor VARCHAR(50),
    Email_Fornecedor VARCHAR(50),
    Telefone_Fornecedor VARCHAR(15)
);
 go
ALTER TABLE Endereco_Cliente  ADD CONSTRAINT FK_Id_Cliente_Endereco_Cliente
    FOREIGN KEY (Id_Cliente)
    REFERENCES Cliente  (Id_Cliente);
 go
ALTER TABLE Pedido  ADD CONSTRAINT FK_Id_Cliente_Pedido
    FOREIGN KEY (Id_Cliente)
    REFERENCES Cliente  (Id_Cliente);
go 
ALTER TABLE Produto  ADD CONSTRAINT FK_Id_Fornecedor_Produto
    FOREIGN KEY (Id_Fornecedor)
    REFERENCES Fornecedor  (Id_Fornecedor);
go 
ALTER TABLE Produto_Pedido  ADD CONSTRAINT FK_Id_Produto_Produto_Pedido
    FOREIGN KEY (Id_Produto)
    REFERENCES Produto  (Id_Produto);
go 
ALTER TABLE Produto_Pedido  ADD CONSTRAINT FK_Id_Pedido_Produto_Pedido
    FOREIGN KEY (Id_Pedido)
    REFERENCES Pedido  (Id_Pedido);
go

INSERT INTO Cliente (Nome_Cliente, Email_Cliente, Senha_Cliente, Telefone_Cliente, CPF_Cliente, Usuario_Cliente) VALUES
('Joao', 'Joao@gmail.com','123','11 12345-6789','123456789','Joao12')
INSERT INTO Cliente (Nome_Cliente, Email_Cliente, Senha_Cliente, Telefone_Cliente, CPF_Cliente,Usuario_Cliente) VALUES
('Jhon', 'Jhon@gmail.com','12345','11 12345-6789','12345678910','Jhon123')
INSERT INTO Cliente (Nome_Cliente, Email_Cliente, Senha_Cliente, Telefone_Cliente, CPF_Cliente,Usuario_Cliente) VALUES
('Douglas', 'Dougla11s@gmail.com','123','11 19345-6789','1234678912','Douglas3')


	INSERT INTO Fornecedor (CNPJ_Fornecedor, Nome_Fornecedor, Email_Fornecedor, Telefone_Fornecedor) VALUES
('12345678901234', 'Fornecedor A', 'contato@fornecedora.com', '11987654321'),
('56789012345678', 'Fornecedor B', 'contato@fornecedorb.com', '11987654322'),
('98765432109876', 'Fornecedor C', 'contato@fornecedorc.com', '11987654323');
go

-- Inserindo produtos agora que os fornecedores existem
INSERT INTO Produto (Id_Fornecedor, Nome_Produto, Img_Produto, Descricao_Produto, Valor_Produto, Peso_Produto, Desconto_Produto, Tamanho_Produto, Quantidade_Produto, Tecido_Produto, Cor_Produto) VALUES
(1, 'Camiseta Branca', 'img_teste.jpg', 'Camiseta de algod�o branca', 39.90, 0.3, 10.00, '34', 50, 'Algod�o', 'Branca'),
(1, 'Camiseta Preta', 'img_teste.jpg', 'Camiseta de algod�o preta', 39.90, 0.3, 10.00, '36', 40, 'Algod�o', 'Preta'),
(2, 'Cal�a Jeans', 'img_teste.jpg', 'Cal�a jeans azul', 99.90, 1.2, 15.00, '42', 30, 'Jeans', 'Azul'),
(2, 'Jaqueta Couro', 'img_teste.jpg', 'Jaqueta de couro sint�tico', 199.90, 1.5, 20.00, '38', 25, 'Couro Sint�tico', 'Preto'),
(3, 'T�nis Esportivo', 'img_teste.jpg', 'T�nis confort�vel para corrida', 149.90, 0.8, 5.00, '42', 60, 'Sint�tico', 'Vermelho'),
(3, 'Mochila Casual', 'img_teste.jpg', 'Mochila para uso di�rio', 79.90, 0.5, 12.00, '40', 45, 'Poli�ster', 'Preto'),
(1, 'Bon� Estiloso', 'img_teste.jpg', 'Bon� de algod�o', 49.90, 0.2, 8.00, '42', 35, 'Algod�o', 'Azul'),
(2, '�culos de Sol', 'img_teste.jpg', '�culos com prote��o UV', 129.90, 0.3, 10.00, '44', 20, 'Pl�stico', 'Preto'),
(3, 'Rel�gio Elegante', 'img_teste.jpg', 'Rel�gio anal�gico de a�o', 399.90, 0.4, 25.00, '46', 15, 'A�o', 'Prata'),
(1, 'Carteira de Couro', 'img_teste.jpg', 'Carteira de couro leg�timo', 89.90, 0.3, 12.00, '48', 50, 'Couro', 'Marrom'),
(2, 'Chap�u Panam�', 'img_teste.jpg', 'Chap�u estiloso para ver�o', 59.90, 0.2, 5.00, '40', 22, 'Palha', 'Bege'),
(3, 'Meia Confort�vel', 'img_teste.jpg', 'Meia de algod�o', 15.90, 0.1, 3.00, '38', 100, 'Algod�o', 'Cinza'),
(1, 'Casaco de L�', 'img_teste.jpg', 'Casaco quente para inverno', 229.90, 1.3, 18.00, '42', 30, 'L�', 'Cinza'),
(2, 'Cal�a Moletom', 'img_teste.jpg', 'Cal�a confort�vel de moletom', 79.90, 1.1, 12.00, '46', 45, 'Moletom', 'Cinza'),
(3, 'Cinto de Couro', 'img_teste.jpg', 'Cinto elegante de couro', 59.90, 0.3, 10.00, '40', 40, 'Couro', 'Preto'),
(1, 'Blusa Feminina', 'img_teste.jpg', 'Blusa leve e estilosa', 49.90, 0.4, 8.00, '34', 35, 'Algod�o', 'Rosa'),
(2, 'Saia Jeans', 'img_teste.jpg', 'Saia curta de jeans', 89.90, 0.7, 15.00, '34', 25, 'Jeans', 'Azul'),
(2, 'Saia Jeans', 'img_teste.jpg', 'Saia curta de jeans', 89.90, 0.7, 15.00, '36', 25, 'Jeans', 'Branco'),
(2, 'Saia Jeans', 'img_teste.jpg', 'Saia curta de jeans', 89.90, 0.7, 15.00, '38', 25, 'Jeans', 'Preto'),
(2, 'Saia Jeans', 'img_teste.jpg', 'Saia curta de jeans', 89.90, 0.7, 15.00, '40', 25, 'Jeans', 'Verde'),
(3, 'Sand�lia Casual', 'img_teste.jpg', 'Sand�lia confort�vel para passeio', 79.90, 0.5, 10.00, '42', 50, 'Couro Sint�tico', 'Marrom'),
(1, 'Vestido Floral', 'img_teste.jpg', 'Vestido estampado', 119.90, 0.6, 20.00, '46', 40, 'Poli�ster', 'Vermelho'),
(2, 'Chinelo de Borracha', 'img_teste.jpg', 'Chinelo simples', 29.90, 0.3, 5.00, '48', 80, 'Borracha', 'Preto');
go
SELECT * FROM Produto
go
SELECT * FROM Produto ORDER BY CASE WHEN 1=1 AND Tecido_Produto IN ('Algod�o', 'Jeans') AND Tamanho_Produto IN ('34', '36', '38') AND Cor_Produto IN ('Cinza', 'Azul', 'Branco', 'Preto') THEN 1 ELSE 2 END, Valor_Produto ASC;
go

SELECT * FROM Produto
WHERE 1=1
AND Tecido_Produto IN ('Algod�o','Jeans')
AND Tamanho_Produto IN ('34','36','38')
AND Cor_Produto IN ( 'Cinza','Azul','Branco','Preto');
go
/*
SELECT Tamanho_Produto, COUNT(*) AS Quantidade
FROM Produto
GROUP BY Tamanho_Produto
ORDER BY Tamanho_Produto ASC;
go
*/
go 
SELECT * FROM Cliente