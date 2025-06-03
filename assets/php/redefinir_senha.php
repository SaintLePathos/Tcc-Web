<?php 
date_default_timezone_set('America/Sao_Paulo');
include("cnxBD.php");

$token = $_GET['token'] ?? '';
$msg = '';
$msgColor = '#ff0000';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = $_POST['senha'] ?? '';
    $confirmaSenha = $_POST['confirma_senha'] ?? '';

    if ($novaSenha !== $confirmaSenha) {
        $msg = "As senhas não coincidem.";
    } else if (strlen($novaSenha) < 8) {
        $msg = "A senha deve ter pelo menos 8 caracteres.";
    } else {
        $sql = $conectar->prepare("SELECT Email_Cliente, TokenExpiraEm FROM Cliente WHERE TokenRecuperacao = :token");
        $sql->bindValue(':token', $token);
        $sql->execute();
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $expira = new DateTime($user['TokenExpiraEm']);
            $agora = new DateTime();

            if ($agora > $expira) {
                $msg = "Token expirado. Solicite uma nova recuperação de senha.";
            } else {
                $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

                $update = $conectar->prepare("UPDATE Cliente SET Senha_Cliente = :senha, TokenRecuperacao = NULL, TokenExpiraEm = NULL WHERE Email_Cliente = :email");
                $update->bindValue(':senha', $senhaHash);
                $update->bindValue(':email', $user['Email_Cliente']);
                $update->execute();

                $msg = "Senha redefinida com sucesso! Redirecionando...";
                $msgColor = "green";
                header("refresh:3;url=../../index.html");
            }
        } else {
            $msg = "Token inválido.";
        }
    }
}

// Formulário de redefinição
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styleuser_info.css" />
    <style>
     body {
    background-color: #f4f4f4;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.recovery-main {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
}

.recovery-container {
    background-color: #fff;
    padding: 40px 20px;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 420px;
    box-sizing: border-box;
}

.recovery-container h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
}

.recovery-container label {
    font-weight: bold;
    color: #333;
    display: block;
    margin-top: 20px;
}

.input-wrapper {
    position: relative;
    width: 100%;
    margin-top: 8px;
}

.input-wrapper input {
    width: 100%;
    padding: 12px 40px 12px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-size: 14px;
    box-sizing: border-box;
}

.toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 20px;
    color: #666;
}

.recovery-container button {
    margin-top: 30px;
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background-color: #000;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

.recovery-container button:hover {
    background-color: #333;
}

.back-button {
    display: block;
    text-align: center;
    margin-top: 20px;
    padding: 12px;
    background-color: #e0e0e0;
    color: #000;
    font-weight: bold;
    border-radius: 8px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.back-button i {
    margin-right: 6px;
    vertical-align: middle;
}

.back-button:hover {
    background-color: #ccc;
}

.msg {
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
}

.recovery-logo {
    display: block;
    margin: 0 auto 20px;
    width: 120px;
}

.footer {
    margin-top: 30px;
    text-align: center;
    font-size: 0.85rem;
    color: #888;
}

        
    </style>
</head>
<body>
    <div class="recovery-main">
        <div class="recovery-container">
            <img src="../img/logo.png" alt="Logo" class="recovery-logo" />
            <h2><i class="bx bx-reset"></i> Redefinir Senha</h2>

            <?php if (!empty($msg)): ?>
                <div class="msg" style="color: <?= $msgColor ?>;"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <label for="senha">Nova Senha</label>
                <div class="input-wrapper">
                    <input type="password" name="senha" id="senha" required>
                    <i class='bx bx-hide toggle-password' toggle="senha"></i>
                </div>

                <label for="confirma_senha">Confirmar Nova Senha</label>
                <div class="input-wrapper">
                    <input type="password" name="confirma_senha" id="confirma_senha" required>
                    <i class='bx bx-hide toggle-password' toggle="confirma_senha"></i>
                </div>

                <button type="submit"><i class="bx bxs-lock-open-alt"></i> Redefinir</button>
            </form>

            <a href="../../index.html" class="back-button"><i class="bx bx-arrow-back"></i> Voltar para o início</a>

            <div class="footer">
                © <?= date('Y') ?> Tardigrado
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function (eyeIcon) {
            eyeIcon.addEventListener('click', function () {
                const inputId = eyeIcon.getAttribute('toggle');
                const input = document.getElementById(inputId);
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                eyeIcon.classList.toggle('bx-hide');
                eyeIcon.classList.toggle('bx-show');
            });
        });
    </script>
</body>
</html>
