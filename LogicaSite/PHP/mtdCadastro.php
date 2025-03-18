<?php
    include(__DIR__."/cnxBD.php");

$tabela = "usuario";

//Mandar dados para a tabela
    try{
    $nome = $_POST["usuariojs"];
    $email = $_POST["emailjs"];
    $senha = $_POST["senhajs"];
    
    $comandoSQL = " SELECT * FROM " . $tabela . " WHERE email = :email ; ";

    $sql = $conectar->prepare($comandoSQL);

    $sql->bindValue(":email", $email);

    $sql->execute();

    //Lo cambia todo

    $resul = $sql->fetchAll(PDO::FETCH_ASSOC);

    if(count($resul)==0){
        
        $comandoSQL = "INSERT INTO ".$tabela.//criando variavel que tera nosso comando sql
        "(nome, email, senha)".//nome das colunas dentro do banco de dados sql
        "VALUES (:nome, :email, :senha);";//aqui sao "variaveis" que usaremos adiantes para por info nelas
        
    
        $sql=$conectar->prepare($comandoSQL);
    
        $sql->bindValue(":nome", $nome);//associando dados as variaveis em sql feitas anteriormente
        $sql->bindValue(":email", $email);//associando dados as variaveis em sql feitas anteriormente
        $sql->bindValue(":senha", $senha);//associando dados as variaveis em sql feitas anteriormente
    
        $sql->execute();

        $retorno = "CadastroS";
        die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }else{
        $retorno = "O email ja esta sendo usado";
        die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
    }catch(Exception $erro){
        $retorno = "Erro: " . $erro->getMessage();
        die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }	 
    
?>