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
    Desconto_Produto INT,
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
    Img_Perfil_Cliente VARCHAR(255)
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
(1, 'Camiseta Branca', 'product-1.png', 'Camiseta de algodão branca', 39.90, 0.3, 10.00, '34', 50, 'Algodão', 'Branca'),
(1, 'Camiseta Preta', 'product-1.png', 'Camiseta de algodão preta', 39.90, 0.3, 10.00, '36', 40, 'Algodão', 'Preta'),
(2, 'Calça Jeans', 'product-1.png', 'Calça jeans azul', 99.90, 1.2, 15.00, '42', 30, 'Jeans', 'Azul'),
(2, 'Jaqueta Couro', 'product-1.png', 'Jaqueta de couro sintético', 199.90, 1.5, 20.00, '38', 25, 'Couro Sintético', 'Preto'),
(3, 'Tênis Esportivo', 'product-1.png', 'Tênis confortável para corrida', 149.90, 0.8, 5.00, '42', 60, 'Sintético', 'Vermelho'),
(3, 'Mochila Casual', 'product-1.png', 'Mochila para uso diário', 79.90, 0.5, 12.00, '40', 45, 'Poliéster', 'Preto'),
(1, 'Boné Estiloso', 'product-1.png', 'Boné de algodão', 49.90, 0.2, 8.00, '42', 35, 'Algodão', 'Azul'),
(2, 'Óculos de Sol', 'product-1.png', 'Óculos com proteção UV', 129.90, 0.3, 10.00, '44', 20, 'Plástico', 'Preto'),
(3, 'Relógio Elegante', 'product-1.png', 'Relógio analógico de aço', 399.90, 0.4, 25.00, '46', 15, 'Aço', 'Prata'),
(1, 'Carteira de Couro', 'product-1.png', 'Carteira de couro legítimo', 89.90, 0.3, 12.00, '48', 50, 'Couro', 'Marrom'),
(2, 'Chapéu Panamá', 'product-1.png', 'Chapéu estiloso para verão', 59.90, 0.2, 5.00, '40', 22, 'Palha', 'Bege'),
(3, 'Meia Confortável', 'product-1.png', 'Meia de algodão', 15.90, 0.1, 3.00, '38', 100, 'Algodão', 'Cinza'),
(1, 'Casaco de Lã', 'product-1.png', 'Casaco quente para inverno', 229.90, 1.3, 18.00, '42', 30, 'Lã', 'Cinza'),
(2, 'Calça Moletom', 'product-1.png', 'Calça confortável de moletom', 79.90, 1.1, 12.00, '46', 45, 'Moletom', 'Cinza'),
(3, 'Cinto de Couro', 'product-1.png', 'Cinto elegante de couro', 59.90, 0.3, 10.00, '40', 40, 'Couro', 'Preto'),
(1, 'Blusa Feminina', 'product-1.png', 'Blusa leve e estilosa', 49.90, 0.4, 8.00, '34', 35, 'Algodão', 'Rosa'),
(2, 'Saia Jeans', 'product-1.png', 'Saia curta de jeans', 89.90, 0.7, 15.00, '34', 25, 'Jeans', 'Azul'),
(2, 'Saia Jeans', 'product-1.png', 'Saia curta de jeans', 89.90, 0.7, 15.00, '36', 25, 'Jeans', 'Branco'),
(2, 'Saia Jeans', 'product-1.png', 'Saia curta de jeans', 89.90, 0.7, 15.00, '38', 25, 'Jeans', 'Preto'),
(2, 'Saia Jeans', 'product-1.png', 'Saia curta de jeans', 89.90, 0.7, 15.00, '40', 25, 'Jeans', 'Verde'),
(3, 'Sandália Casual', 'product-1.png', 'Sandália confortável para passeio', 79.90, 0.5, 10.00, '42', 50, 'Couro Sintético', 'Marrom'),
(1, 'Vestido Floral', 'product-1.png', 'Vestido estampado', 119.90, 0.6, 20.00, '46', 40, 'Poliéster', 'Vermelho'),
(2, 'Chinelo de Borracha', 'product-1.png', 'Chinelo simples', 29.90, 0.3, 5.00, '48', 80, 'Borracha', 'Preto');
go
SELECT * FROM Produto

--SELECT * FROM Produto ORDER BY CASE WHEN 1=1 AND Tecido_Produto IN ('Algodão', 'Jeans') AND Tamanho_Produto IN ('34', '36', '38') AND Cor_Produto IN ('Cinza', 'Azul', 'Branco', 'Preto') THEN 1 ELSE 2 END, Valor_Produto ASC;
/*
SELECT * FROM Produto
WHERE 1=1
AND Tecido_Produto IN ('Algod�o','Jeans')
AND Tamanho_Produto IN ('34','36','38')
AND Cor_Produto IN ( 'Cinza','Azul','Branco','Preto');
go

SELECT Tamanho_Produto, COUNT(*) AS Quantidade
FROM Produto
GROUP BY Tamanho_Produto
ORDER BY Tamanho_Produto ASC;
go

go 
SELECT * FROM Cliente

--Procedure de autentificação


CREATE PROCEDURE mySp_autenticaUsuario

	--definindo parâmetros de entrada
	@login varchar(20),
	@senha varchar(20)
AS
	--criando variaveis
	DECLARE @getLogin varchar(50), @getSenha varchar(255)

	--definindo o valor de cada variavel
	SET @getLogin = (SELECT Email_Cliente FROM Cliente
											WHERE Email_Cliente = @login)
	SET @getSenha = (SELECT Senha_Cliente FROM Cliente 
											WHERE Senha_Cliente = @senha)

	--condicional para retornarmos o login
	if(LEN(@getLogin) > 0) AND (LEN(@getSenha) > 0)
		BEGIN 
		-- trabalhando com condicionais aninhados
		IF(@getLogin <> '') AND (@getSenha <>'')
			BEGIN
				SELECT ('Usuario pode ser logado pois os dados conferem ...') AS logger
			END
		END
	ELSE
		BEGIN
		SELECT ('Usuario não pode ser logado pois os dados não conferem ...') AS logger
		END

EXEC mySp_autenticaUsuario 'Jhon@gmail.com', '1235' */