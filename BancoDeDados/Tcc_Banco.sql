
USE MASTER
GO 
CREATE DATABASE Loja_Ecomerce
GO
USE Loja_Ecomerce

CREATE TABLE Cliente (
    Id_Cliente int primary key identity ,
    Usuario varchar(40),
	Nome varchar(40),
	Senha varchar(30),
	Email varchar(50),
	Telefone varchar(30),
	Cpf varchar(20),
	Img_Perfil varchar(40)
)
GO

CREATE TABLE Endereco_Cliente
(
	Id_Endereco_Cliente int primary key identity,
	Id_Cliente int,
	Estado varchar(2),
	Municipio varchar(15),
	Rua varchar(40),
	Numero_endereco varchar(4),
	CEP varchar(10),
	Referencias varchar(200)

	Foreign key (Id_Cliente) References Cliente(Id_Cliente)
)
GO
CREATE TABLE Pedido(
	
	Id_Pedido int primary key identity,
	Id_Cliente int,
	Id_Endereco_Cliente int,
	Data_Pedido date,
	Data_Entrega date,
	Valor decimal(10,2),
	Devolucao BIT,
	Data_Devolucao date,
	Motivo_Devolucao varchar(500)

	Foreign Key (Id_Cliente) References Cliente(Id_Cliente)
)

GO


CREATE TABLE Carrinho (
	Id_Carrinho int primary key identity,
	Id_Cliente int,


	Foreign Key (Id_Cliente) References Cliente(Id_Cliente) 
)
GO
 
CREATE TABLE Modelo(
	Id_Modelo int primary key identity,
	Referencia Varchar(40),
	Tipo Varchar (30),
	Tamanho varchar (8),
)
GO
CREATE TABLE Lote (

	Id_Lote int primary key identity,
	Id_Modelo int,
	Data_registro_Lote date,
	Custo_Lote Decimal(10,2),
	Quantidade int
	
	Foreign Key (Id_Modelo) References Modelo (Id_Modelo)
)
GO

CREATE TABLE Tecido (
	
	Id_Tecido int primary key identity,
	Id_Lote int,
	Nome varchar(30),
	Data_Registro_Tecido date,
	Custo_Tecido Decimal(10,2),
	Cor Varchar(10),
	Comprimento Decimal (10,2),
	Largura Decimal (10,2),
	Gramatura Varchar (30)

	Foreign Key (Id_Lote) References Lote (Id_Lote)

)

GO

CREATE TABLE Produto (

	Id_Produto int primary key identity,
	Id_Tecido int,
	Id_Modelo int,
	Nome varchar(40),
	Tipo_Modelo varchar(40),
	Quantidade int,
	Descricao varchar(200),
	Valor_Produto decimal(10,2),
	Peso varchar(20)

	Foreign Key (Id_Tecido) References Tecido (Id_Tecido),
	Foreign Key (Id_Modelo) References Modelo (Id_Modelo)

)

GO

CREATE TABLE Carrinho_Produto(
	Id_Carrinho int,
	Id_Produto int,
	Quantidade_Produto int,
	Valor_Quantidade_Produto int
	
)

GO

CREATE TABLE Produto_Pedido (
	
	Id_Pedido int,
	Id_Produto int,
	Quantidade_Produto int,
	Nome_Produto varchar(40)

	Foreign Key (Id_Pedido) References Pedido (Id_Pedido),
	Foreign Key (Id_Produto) References Produto (Id_Produto)
)
GO
CREATE TABLE Produto_Lote(

	Id_Produto int,
	Id_Lote int,
	Data_Registro date,
	Quantidade int

	Foreign Key (Id_Produto) References Produto (Id_Produto),
	Foreign Key (Id_Lote) References Lote(Id_Lote)

)
GO
CREATE TABLE Endereco_Oficina(
 Id_Endereco_Oficina int primary key identity,
 Estado varchar(2),
 Municipio varchar(40),
 Rua varchar(50),
 Numero varchar(6),
 Cep varchar(10),
 Referencia varchar (200)

)
GO
CREATE TABLE Oficina (
	Id_Oficina int primary key identity,
	Id_Endereco_Oficina int,
	Nome varchar(20),
	Tipo varchar (30),
	
	Foreign Key (Id_Endereco_Oficina) References Endereco_Oficina(Id_Endereco_Oficina)

)
GO
Create Table Oficina_Lote(
	Id_Oficina int,
	Id_Lote int,
	Custo_Servico decimal(10,2),
	Data_Entrada date,
	Data_Saida date,
	Quantidade_Entrada int,
	Quantidade_Saida int

)

GO

select * from Cliente