<?php

include(__DIR__."/assets/php/cnxBD.php");

$tabela = "Cliente";


try{

    $novousuario = $_POST["usuario"];
    $novonome = $_POST["nome"];
    $novoemail = $_POST["email"]; 
    $novasenha = $_POST["senha"];
    $confirmaSenha = $_POST["confirma_senha"];
    $novotelefone = $_POST["telefone"];
    $novocpf = $_POST["cpf"];
    if ($novasenha ==  $confirmaSenha){
        $novasenha = password_hash($novasenha,PASSWORD_DEFAULT);
    }
    
    $sql=$conectar->prepare("INSERT INTO ".$tabela." (usuario, nome , email, senha, telefone, cpf) VALUES(:usuario,:nome,:email,:senha,:telefone,:cpf);");

    $sql->bindValue(":usuario",$novousuario);
    $sql->bindValue(":nome",$novonome);
    $sql->bindValue(":email",$novoemail);
    $sql->bindValue(":senha",$novasenha);
    $sql->bindValue(":telefone",$novotelefone);
    $sql->bindValue(":cpf",$novocpf);

    $sql->execute();
    echo "Cadastro com sucesso";
    sleep(5);
    header('Location: index.html');
    die;


}catch(Exception $erro){
    echo "ATENÇÃO, erro na inclusão: ".$erro->getMessage();
};
?>