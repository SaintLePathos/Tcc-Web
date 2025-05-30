<?php
date_default_timezone_set('America/Sao_Paulo');
include("cnxBD.php");

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = $_POST['senha'] ?? '';
    $confirmaSenha = $_POST['confirma_senha'] ?? '';

    if ($novaSenha !== $confirmaSenha) {
        echo "As senhas não coincidem.";
        exit;
    }else if(strlen($novaSenha) < 8){}

    // Verifica token
    $sql = $conectar->prepare("SELECT Email_Cliente FROM Cliente WHERE TokenRecuperacao = :token AND TokenExpiraEm >= GETDATE()");
    $sql->bindValue(':token', $token);
    $sql->execute();
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        // Atualiza senha e remove o token
        $update = $conectar->prepare("UPDATE Cliente SET Senha_Cliente = :senha, TokenRecuperacao = NULL, TokenExpiraEm = NULL WHERE Email_Cliente = :email");
        $update->bindValue(':senha', $senhaHash);
        $update->bindValue(':email', $user['Email_Cliente']);
        $update->execute();

        echo "Senha redefinida com sucesso!";
    } else {
        echo "Token inválido ou expirado.";
    }
} else {
    // Formulário
    echo "
    <form method='post'>
        <input type='hidden' name='token' value='$token'>
        <label>Nova Senha:</label>
        <input type='password' name='senha' required><br>
        <label>Confirmar Senha:</label>
        <input type='password' name='confirma_senha' required><br>
        <button type='submit'>Redefinir Senha</button>
    </form>
    ";
}
?>
