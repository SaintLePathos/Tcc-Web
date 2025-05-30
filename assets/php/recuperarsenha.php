<?php
date_default_timezone_set('America/Sao_Paulo');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



include("cnxBD.php");

if ($_POST) {
    $emailRecupera = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($emailRecupera, FILTER_VALIDATE_EMAIL)) {
        exit("E-mail inválido.");
    }

    $sql = $conectar->prepare("SELECT Email_Cliente FROM Cliente WHERE Email_Cliente = :email");
    $sql->bindValue(":email", $emailRecupera);
    $sql->execute();
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo "Usuário encontrado. Mandaremos uma senha de recuperação no seu e-mail.";

  
        $token = bin2hex(random_bytes(16));
        $expiraObj = new DateTime('+15 minutes');
        $expira = $expiraObj->format('Y-m-d\TH:i:s'); // Para o banco
        $expiraFormatada = $expiraObj->format('d/m/Y \à\s H:i'); // Para exibir

        echo "Token expira em: $expiraFormatada<br>";
        

        
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
    $mail->addAddress($emailRecupera, 'eu');     //Add a recipient
   

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
    echo "E-mail de recuperação enviado com sucesso!";
        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
        }


    } else {
        echo "Usuário não encontrado.";
    }
}
?>


<form method="post">
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <button type="submit">Recuperar Senha</button>
</form>
