<?php
date_default_timezone_set('America/Sao_Paulo');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



include("cnxBD.php");
$mensagem = "";

if ($_POST) {
    $emailRecupera = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($emailRecupera, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "<span style='color:red;'>E-mail inválido.</span>";
    }

    $sql = $conectar->prepare("SELECT Email_Cliente FROM Cliente WHERE Email_Cliente = :email");
    $sql->bindValue(":email", $emailRecupera);
    $sql->execute();
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {

  
        $token = bin2hex(random_bytes(16));
        $expiraObj = new DateTime('+15 minutes');
        $expira = $expiraObj->format('Y-m-d\TH:i:s'); // Para o banco
        $expiraFormatada = $expiraObj->format('d/m/Y \à\s H:i'); // Para exibir

       
        

        
        $update = $conectar->prepare("UPDATE Cliente SET TokenRecuperacao = :token, TokenExpiraEm = :expira WHERE Email_Cliente = :email");

        $update->bindValue(":token", $token);
        $update->bindValue(":expira", $expira);
        $update->bindValue(":email", $emailRecupera);
        $update->execute();

        $mail = new PHPMailer(true);

          try {
            //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'diegodouglas452@gmail.com';                     //SMTP username
    $mail->Password   = 'ztom lyvi tubw rfbe';                               //SMTP password
    $mail->SMTPSecure =  PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port    = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('diegodouglas452@gmail.com', 'Tardigrado');
    $mail->addAddress($emailRecupera, 'Usuaario');     //Add a recipient
   

$link = "http://localhost/Tcc-Web/assets/php/redefinir_senha.php?token=$token";

    //Content
   $mail->isHTML(true);
    $mail->Subject = 'Recuperação de senha';
$mail->Body = "
    <div style='text-align: center;'>
        <img src='http://localhost/Tcc-Web/assets/img/logo.png' width='150' alt='Logo' style='display:block; margin:auto;'>
    </div>
    <br>
    <p>Olá,</p>
    <p>Você solicitou a recuperação de senha.</p>
     <p><a href='$link'>$link</a></p>
    <p>Este código expira em $expiraFormatada.</p>
    <p>Se você não solicitou, por favor ignore este e-mail.</p>
    <br>
    <div style='text-align: center;'>
        <img src='http://localhost/Tcc-Web/assets/img/footer-logo.png' width='150' alt='Rodapé' style='display:block; margin:auto;'>
    </div>
";

    $mail->send();
    $mensagem = "<span style='color:green;'>Usuário encontrado. Link de recuperação enviado para o e-mail informado.<br>Expira em: $expiraFormatada</span>";
        } catch (Exception $e) {
            $mensagem = "<span style='color:red;'>Erro ao enviar o e-mail: {$mail->ErrorInfo}</span>";
        }


    } else {
          $mensagem = "<span style='color:red;'>Usuário não encontrado.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Recuperar Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link rel="stylesheet" href="assets/css/styleuser_info.css" /> <!-- Mesmo CSS da user-info.php -->

    <style>
    body {
        background-color: #f4f4f4;
        font-family: 'Arial', sans-serif;
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
        padding: 40px 30px;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 420px;
        box-sizing: border-box;
    }

    .recovery-logo {
        display: block;
        margin: 0 auto 20px;
        width: 100px;
        max-width: 120px;
    }

    .recovery-container h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
        font-size: 1.5rem;
    }

    .recovery-container label {
        font-weight: bold;
        color: #333;
        display: block;
        margin-top: 20px;
        font-size: 0.95rem;
    }

    .recovery-container input[type="email"] {
        width: 100%;
        padding: 12px;
        margin-top: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-size: 14px;
        box-sizing: border-box;
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

    .footer {
        margin-top: 30px;
        text-align: center;
        font-size: 0.85rem;
        color: #888;
    }

    .mensagem {
        text-align: center;
        margin-top: 15px;
        font-size: 0.9rem;
        padding: 10px;
        border-radius: 6px;
        background-color: #f0f0f0;
        color: #333;
        word-wrap: break-word;
    } .back-button {
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


    /* Responsividade */
    @media (max-width: 480px) {
        .recovery-container {
            padding: 30px 20px;
        }

        .recovery-container h2 {
            font-size: 1.25rem;
        }

        .recovery-container button {
            font-size: 15px;
        }

        .mensagem {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 360px) {
        .recovery-container {
            padding: 20px 15px;
        }

        .recovery-logo {
            width: 80px;
        }
    }
</style>

</head>
<body>
    <div class="recovery-main">
        <div class="recovery-container">
            <img src="../img/logo.png" alt="Logo" class="recovery-logo" />
            <h2><i class='bx bx-lock'></i> Recuperar Senha</h2>

            <form method="post">
                <label for="email">E-mail cadastrado:</label>
                <input type="email" name="email" required placeholder="exemplo@dominio.com">

                <!-- Aqui aparece a mensagem -->
                <?php if (!empty($mensagem)): ?>
                    <div class="mensagem"><?= $mensagem ?></div>
                <?php endif; ?>

                <button type="submit"><i class='bx bxs-send'></i> Enviar link de recuperação</button>
                <a href="../../index.html" class="back-button">
    <i class='bx bx-arrow-back'></i> Voltar para o início
</a>

            </form>

            <div class="footer">
                © <?= date('Y') ?> Tardigrado
            </div>
        </div>
    </div>
</body>
</html>
