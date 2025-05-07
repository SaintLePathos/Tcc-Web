<?php
include(__DIR__."/assets/php/cnxBD.php");

$tabela = "Cliente";

try {
    // Sanitização e validação dos campos
    
    $novonome      =  $_POST['nome'];
    $novoemail     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $novotelefone  = $_POST['celular'];
    $novocpf       = $_POST['cpf'];
    $novasenha     = $_POST['senha'];
    $confirmaSenha = $_POST['confirma_senha'];

    // Validação simples
    if (!$novotelefone || !$novonome || !$novoemail || !$novasenha || !$confirmaSenha || !$novocpf) {
        exit("Todos os campos obrigatórios devem ser preenchidos.");
    }

    if (!filter_var($novoemail, FILTER_VALIDATE_EMAIL)) {
        exit("E-mail inválido.");
    }

    if ($novasenha !== $confirmaSenha) {
        exit("As senhas não coincidem.");
    }

    // Criptografar a senha com password_hash
    $hashSenha = password_hash($novasenha, PASSWORD_DEFAULT);

    // Preparar e executar a inserção no banco
    $sql = $conectar->prepare("
        INSERT INTO $tabela ( Nome_CLiente, Email_Cliente, Senha_Cliente, Telefone_Cliente, CPF_Cliente)
        VALUES ( :nome, :email, :senha, :telefone, :cpf)
    ");


    $sql->bindValue(":nome", $novonome);
    $sql->bindValue(":email", $novoemail);
    $sql->bindValue(":senha", $hashSenha);
    $sql->bindValue(":telefone", $novotelefone);
    $sql->bindValue(":cpf", $novocpf);

    $sql->execute();

    // Redirecionamento seguro
    header('Location: user-info.php');
    exit;

} catch (Exception $erro) {
    echo "ATENÇÃO, erro na inclusão: " . $erro->getMessage();
}
?>
