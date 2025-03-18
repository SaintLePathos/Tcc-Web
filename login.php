<?php

if($_POST){

    session_start();
    require "conexao.php";

    $pdo= conectar();
    $tabela = "Cliente";
    
    try{
        if(!empty($_POST["email"] && !empty($_POST["senha"])))
        {
            $novo_email = $_POST["email"];
            $nova_senha = $_POST["senha"];
            $sql = $pdo->prepare("SELECT Email,Senha FROM ".$tabela." WHERE Email = :email AND Senha = :senha");

            $sql->bindValue(":email",$novo_email);
            $sql->bindValue(":senha",$nova_senha);

            $sql->execute();

            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
            
            if($resultado){
                
                echo "Usuario encontrado";
                header('location: usuario-info.html');
                die;
            }else{
                echo "usuario não encontrado";
                header('location: index.html');
            }
        }

    }catch(Exception $erro)
    {
        echo "ATENÇÃO, erro na consulta: ".$erro->getMessage();

    }




}else{

    header("location: index.html");
    die;

}

?>