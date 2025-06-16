<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include(__DIR__ . "/assets/php/cnxBD.php");

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST["senha"] ?? '';

    if (!$email || !$senha || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_erro'] = "Preencha os campos corretamente.";
        header("Location: index.html");
        exit;
    }

    try {
        $sql = $conectar->prepare("EXEC mySp_getSenhaPorLogin :email");
        $sql->bindValue(":email", $email);
        $sql->execute();

        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($senha, $resultado['Senha_Cliente'])) {
            $_SESSION['email'] = $email;
            header('Location: index.html');
            exit;
        } else {
            $_SESSION['login_erro'] = "Usuário não encontrado ou senha incorreta.";
            header('Location: index.html');
            exit;
        }

    } catch (Exception $e) {
        $_SESSION['login_erro'] = "Erro no servidor: " . $e->getMessage();
        header('Location: index.html');
        exit;
    }

} else {
    header("Location: index.html");
    exit;
}
?>
