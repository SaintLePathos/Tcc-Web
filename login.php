<?php

if($_POST){

    session_start();
    include(__DIR__."/assets/php/cnxBD.php");

    $tabela = "Cliente";

    try{
        if(!empty($_POST["email"]) && !empty($_POST["senha"]))
        {
            $novo_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $nova_senha = $_POST["senha"];

            if (!filter_var($novo_email, FILTER_VALIDATE_EMAIL)) {
                exit("E-mail inválido.");
            }
        
            // Buscar apenas o hash da senha pelo e-mail
            $sql = $conectar->prepare("SELECT Email_Cliente, Senha_Cliente FROM $tabela WHERE Email_Cliente = :email");
            $sql->bindValue(":email", $novo_email);
            $sql->execute();

            $resultado = $sql->fetch(PDO::FETCH_ASSOC);

            if($resultado && password_verify($nova_senha, $resultado['Senha_Cliente'])){
                $_SESSION['email'] = $novo_email;
                echo "Usuário encontrado";
                sleep(2);
                header('location: user-info.php');
                exit;
            } else {
                echo "Usuário não encontrado ou senha incorreta";
                header('refresh:2;url=index.html');
                exit;
            }
        } else {
            echo "Preencha todos os campos";
            header('refresh:2;url=index.html');
            exit;
        }

    } catch(Exception $erro){
        echo "ATENÇÃO, erro na consulta: ".$erro->getMessage();
    }

} else {
    header("location: index.html");
    exit;
}

?>
