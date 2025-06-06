<?php
header('Content-Type: application/json');

include(__DIR__."/cnxBD.php");

$tabela = "Cliente";

try {
    if (!empty($_POST["email"]) && !empty($_POST["senha"])) {
        $novo_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $nova_senha = $_POST["senha"];

        // Buscar o hash da senha e ID do usuário pelo email
        $sql = $conectar->prepare("SELECT Id_Cliente, Senha_Cliente FROM $tabela WHERE Email_Cliente = :email");
        $sql->bindParam(":email", $novo_email, PDO::PARAM_STR);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($nova_senha, $resultado['Senha_Cliente'])) {
            echo json_encode([
                "status" => "success",
                "message" => "Login realizado com sucesso!",
                "user_id" => $resultado['Id_Cliente']
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Credenciais inválidas!"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Dados incompletos!"
        ]);
    }
} catch (Exception $erro) {
    echo json_encode([
        "status" => "error",
        "message" => "Erro no servidor!"
    ]);
}
?>
