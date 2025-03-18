<?php
    include(__DIR__."/cnxBD.php");

$tabela = "usuario";

try{

    $usuario = $_POST["usuariojs"];
    $senha = $_POST["senhajs"];

    $comandoSQL = " SELECT * FROM " . $tabela . " WHERE nome = :usuario ; ";

    $sql = $conectar->prepare($comandoSQL);

    $sql->bindValue(":usuario", $usuario);

    $sql->execute();

    //Apartir de aqui logica de login

    $resul = $sql->fetchAll(PDO::FETCH_ASSOC);

    if(count($resul)>0){
        foreach($resul as $indice => $conteudo){
            if($usuario == $conteudo["nome"] && $senha == $conteudo["senha"]){
                $retorno = "usuario/senha_S";
                die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));//retorna o que esta na variavel $retorno para a chamada ajax
            }else{
                $retorno = "usuario/senha_N";
                die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }else{
        throw new Exception("Nenhum resultado encontrado");
    }
}catch(Exception $erro){
    $retorno = "erro";
        die(json_encode($retorno, 
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES));	 
}
?>