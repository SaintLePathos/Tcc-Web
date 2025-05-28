<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.html');
    exit;
}

include("cnxBD.php"); // Conexão PDO com SQL Server

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_SESSION['email'];

    // Sanitização básica
    $senha_atual = trim($_POST['senha_atual'] ?? '');
    $nova_senha = trim($_POST['nova_senha'] ?? '');
    $confirmar_senha = trim($_POST['confirmar_senha'] ?? '');

    // Validação básica de comprimento
    if (strlen($nova_senha) < 8) {
        $mensagem = "A nova senha deve ter no mínimo 8 caracteres.";
    } elseif ($nova_senha !== $confirmar_senha) {
        $mensagem = "As novas senhas não conferem.";
    } else {
        $sql = $conectar->prepare("SELECT Senha_Cliente FROM Cliente WHERE Email_Cliente = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$resultado) {
            $mensagem = "Usuário não encontrado.";
        } else {
            $senha_hash = $resultado['Senha_Cliente'];

            if (!password_verify($senha_atual, $senha_hash)) {
                $mensagem = "Senha atual incorreta.";
            } else {
                // Hash e update
                $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

                $sqlUpdate = $conectar->prepare("UPDATE Cliente SET Senha_Cliente = :nova_senha WHERE Email_Cliente = :email");
                $sqlUpdate->bindValue(":nova_senha", $nova_senha_hash);
                $sqlUpdate->bindValue(":email", $email);

                if ($sqlUpdate->execute()) {
                    $mensagem = "Senha alterada com sucesso!";
                } else {
                    $mensagem = "Erro ao alterar senha.";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Alterar Senha</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f9f9ff;
      color: #333;
    }

    .logout-container {
      position: absolute;
      top: 20px;
      right: 20px;
      z-index: 1000;
    }

    .logout-btn {
      background-color: #000;
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .logout-btn:hover {
      background-color: #1d1d1d;
    }

    .container {
      max-width: 380px;
      margin: 100px auto 30px;
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .container h2 {
      margin-bottom: 1.5rem;
      text-align: center;
      font-size: 20px;
    }

    .input-group {
      margin-bottom: 1.2rem;
    }

    label {
      font-weight: 500;
      margin-bottom: 5px;
      display: block;
      font-size: 14px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-wrapper input {
      width: 100%;
      padding: 0.7rem 2.5rem 0.7rem 0.7rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      box-sizing: border-box;
    }

    .input-wrapper i.toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      color: #999;
      cursor: pointer;
    }

    .form-actions {
      margin-top: 1.5rem;
      display: flex;
      gap: 1rem;
    }

    .form-actions button {
      flex: 1;
      padding: 0.7rem;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
    }

    button.save {
      background-color: black;
      color: white;
    }

    button.save:hover {
      background-color: #1d1d1d;
    }

    button.cancel {
      background-color: #eee;
    }

    .esqueci-senha {
      text-align: center;
      margin-top: 20px;
    }

    .esqueci-senha a {
      font-size: 13px;
      color: #007bff;
      text-decoration: none;
    }

    .esqueci-senha a:hover {
      text-decoration: underline;
    }

    @media (max-width: 600px) {
      .container {
        margin: 80px 1rem;
      }

      .form-actions {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

<div class="logout-container">
  <a href="http://localhost/Tcc-Web/user-info.php" class="logout-btn">
    <i class='bx bx-log-out'></i> Voltar
  </a>
</div>



<div class="container">
  <h2>Alterar Senha</h2>

  <form action="alterarSenha.php" method="POST">
    <div class="input-group">
      <label for="senha_atual">Senha Atual</label>
      <div class="input-wrapper">
        <input type="password" id="senha_atual" name="senha_atual" required>
        <i class='bx bx-hide toggle-password' onclick="togglePassword(this, 'senha_atual')"></i>
      </div>
    </div>

    <div class="input-group">
      <label for="nova_senha">Nova Senha</label>
      <div class="input-wrapper">
        <input type="password" id="nova_senha" name="nova_senha" required>
        <i class='bx bx-hide toggle-password' onclick="togglePassword(this, 'nova_senha')"></i>
      </div>
    </div>

    <div class="input-group">
      <label for="confirmar_senha">Confirmar Nova Senha</label>
      <div class="input-wrapper">
        <input type="password" id="confirmar_senha" name="confirmar_senha" required>
        <i class='bx bx-hide toggle-password' onclick="togglePassword(this, 'confirmar_senha')"></i>
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="save">Salvar</button>
      <button type="reset" class="cancel">Cancelar</button>
    </div>
  </form>

  <div class="esqueci-senha">
    <a href="recuperar_senha.php">Esqueci minha senha</a>
  </div>
</div>

<script>
  function togglePassword(icon, inputId) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === "password";
    input.type = isPassword ? "text" : "password";
    icon.classList.toggle("bx-hide", !isPassword);
    icon.classList.toggle("bx-show", isPassword);
  }
</script>

</body>
</html>

