<?php
if($_POST){
include(__DIR__."/assets/php/cnxBD.php");
session_start();
$tabela = "Cliente";

try {
    // Sanitização
    $novonome      = strip_tags(trim($_POST['nome']));
    $novoemail     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $novotelefone  = preg_replace('/[^0-9]/', '', $_POST['celular']);
    $novocpf       = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    $novasenha     = $_POST['senha'];
    $confirmaSenha = $_POST['confirma_senha'];

    // Validações
    if (!$novonome || !$novoemail || !$novotelefone || !$novocpf || !$novasenha || !$confirmaSenha) {
        exit("Todos os campos obrigatórios devem ser preenchidos.");
      
    }

    if (!filter_var($novoemail, FILTER_VALIDATE_EMAIL)) {
        exit("E-mail inválido.");
    }
    if (strlen($novasenha) < 8  || strlen($novasenha) > 15 ) {
       exit("A nova senha deve ter no mínimo 8 caracteres e maximo 15 caracteres");

    }
     if(strlen($novotelefone) < 11){
                    exit("Digite um número com 11 digitos");
                    
    }
      if(strlen($novocpf) < 11){
                    exit("Digite um CPF válido");
                    
    }
    if ($novasenha !== $confirmaSenha) {
        exit("As senhas não coincidem.");
    }
     

    // Verificar duplicidade de e-mail ou CPF
    $verifica = $conectar->prepare("SELECT COUNT(*) FROM $tabela WHERE Email_Cliente = :email OR CPF_Cliente = :cpf");
    $verifica->bindValue(":email", $novoemail);
    $verifica->bindValue(":cpf", $novocpf);
    $verifica->execute();

    if ($verifica->fetchColumn() > 0) {
        exit("Já existe um cadastro com este e-mail ou CPF.");
    }

    // Hash da senha
    $hashSenha = password_hash($novasenha, PASSWORD_DEFAULT);


    // Inserção
    $sql = $conectar->prepare("
        INSERT INTO $tabela (Nome_CLiente, Email_Cliente, Senha_Cliente, Telefone_Cliente, CPF_Cliente)
        VALUES (:nome, :email, :senha, :telefone, :cpf)
    ");

    $sql->bindValue(":nome", $novonome);
    $sql->bindValue(":email", $novoemail);
    $sql->bindValue(":senha", $hashSenha);
    $sql->bindValue(":telefone", $novotelefone);
    $sql->bindValue(":cpf", $novocpf);

    $sql->execute();

   $_SESSION['email'] = $novoemail;

    header('Location: user-info.php');
    exit;

} catch (Exception $erro) {
    echo "ATENÇÃO, erro na inclusão: " . $erro->getMessage();
}}
else{
    header('Location: index.html');
    exit;
}
?>
