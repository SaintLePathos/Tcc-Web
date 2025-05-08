<?php 
session_start();
include(__DIR__."/assets/php/cnxBD.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header('Location: index.html');
    exit;
}

$email_sessao = $_SESSION['email'];

// Se o formulário foi enviado (POST), atualiza os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $novo_nome =  strip_tags(trim($_POST['nome']));
     $novo_usuario = strip_tags(trim($_POST['usuario']));
    $novo_email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $novo_telefone  = preg_replace('/[^0-9]/', '', $_POST['telefone']);  
    $novo_cpf       = preg_replace('/[^0-9]/', '', $_POST['cpf']); 

    try {
        $atualiza = $conectar->prepare("
            UPDATE Cliente 
            SET 
                Nome_Cliente = :nome, 
                Usuario_Cliente = :usuario, 
<<<<<<< HEAD
                Email_Cliente = :email, 
=======
>>>>>>> 517b4cd7263e5855b0f79f27db68633cd110b982
                Telefone_Cliente = :telefone,
                CPF_Cliente = :cpf
            WHERE Email_Cliente = :email_sessao
        ");
        $atualiza->bindValue(':nome', $novo_nome);
        $atualiza->bindValue(':usuario', $novo_usuario);
        $atualiza->bindValue(':email', $novo_email);
        $atualiza->bindValue(':telefone', $novo_telefone);
        $atualiza->bindValue(':cpf', $novo_cpf);
        $atualiza->bindValue(':email_sessao', $email_sessao);
        $atualiza->execute();

        $_SESSION['email'] = $novo_email;
        header("Location: user-info.php?sucesso=1");
        exit;

    } catch (Exception $e) {
        echo "Erro ao atualizar dados: " . $e->getMessage();
        exit;
    }
}

// Carrega os dados atuais
try {
    $sql = $conectar->prepare("
        SELECT Nome_Cliente, Usuario_Cliente, Email_Cliente, Telefone_Cliente,CPF_Cliente 
        FROM Cliente 
        WHERE Email_Cliente = :email
    ");
    $sql->bindValue(":email", $email_sessao);
    $sql->execute();

    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "Usuário não encontrado.";
        exit;
    }

} catch (Exception $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Editar Perfil do Usuário</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="assets/css/style_cadastro.css" />
 <!-- jQuery e jQuery Mask -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <style>
    #sucesso-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    #sucesso-box {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      font-family: Arial, sans-serif;
    }

    #sucesso-box h2 {
      color: green;
      margin-bottom: 10px;
    }

    #sucesso-box p {
      margin: 10px 0;
    }

    #sucesso-box button {
      margin-top: 15px;
      padding: 10px 20px;
      background-color: green;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    #sucesso-box button:hover {
      background-color: darkgreen;
    }
  </style>
</head>
<body>

  <main class="user-edit">
    <div class="user-photo">
      <div class="image-container">
        <img src="https://www.w3schools.com/w3images/avatar2.png" alt="Ícone de Usuário" id="userImage" />
        <label for="imgPerfil" class="edit-icon"><i class='bx bxs-pencil'></i></label>
      </div>
    </div>

    <form class="user-form" method="post">
      <h1>Editar Perfil</h1>

      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['Nome_Cliente']) ?>" required />

    
      <label for="CPF">CPF</label>
      <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($usuario['CPF_Cliente']) ?>" />

      <label for="usuario">Nome de Usuário</label>
      <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario['Usuario_Cliente']) ?>" required />

      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['Email_Cliente']) ?>" required />

      <label for="telefone">Telefone</label>
      <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($usuario['Telefone_Cliente']) ?>" />

      <div class="form-actions">
        <button type="submit" class="save">Salvar Alterações</button>
        <button type="reset" class="cancel">Cancelar</button>
      </div>
    </form>
 <!-- Botão de logout -->
 <form method="post" action="logout.php">
        <button type="submit" class="logout-btn">Sair</button>
    </form>

  </main>

  <!-- Overlay de Sucesso -->
  <div id="sucesso-overlay">
    <div id="sucesso-box">
      <h2><i class='bx bxs-check-circle'></i> Sucesso!</h2>
      <p>Seus dados foram atualizados com sucesso.</p>
      <button onclick="fecharOverlay()">OK</button>
    </div>
  </div>

  <script>
    $(document).ready(function(){
      $('#telefone').mask('(00) 00000-0000');
  
       $('#cpf').mask('000.000.000-00');
    });
  </script>
  <script>
    function fecharOverlay() {
      window.location.href = window.location.pathname;
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('sucesso') === '1') {
      document.getElementById('sucesso-overlay').style.display = 'flex';
    }
  </script>

</body>
</html>
