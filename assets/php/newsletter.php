<?php 
date_default_timezone_set('America/Sao_Paulo');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


include("cnxBD.php");

if($_POST){
$mail = new PHPMailer(true);

    $emailUsuario = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "<span style='color:red;'>E-mail inválido.</span>";
    }


try {
    // Configurações básicas
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'diegodouglas452@gmail.com';
    $mail->Password = 'ztom lyvi tubw rfbe';
    $mail->SMTPSecure =  PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port    = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';
    //Recipients
    $mail->setFrom('diegodouglas452@gmail.com', 'Tardigrado');
    $mail->addAddress($emailUsuario, 'Usuaario');     //Add a recipient

    $mail->isHTML(true);
    $mail->Subject = 'Boletim Informativo - Junho';
$corpoEmail = '
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .email-container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h1 {
      color: #000000;
      font-size: 24px;
    }
    p {
      font-size: 16px;
    }
    .product {
      display: flex;
      align-items: center;
      margin: 20px 0;
      border: 1px solid #eee;
      border-radius: 8px;
      overflow: hidden;
    }
    .product img {
      width: 120px;
      height: auto;
      object-fit: cover;
    }
    .product-details {
      padding: 15px;
      flex-grow: 1;
    }
    .product-details h3 {
      margin: 0 0 10px;
      font-size: 18px;
      color: #000000;
    }
    .product-details p {
      margin: 0;
      color: #666;
      font-size: 14px;
    }
    .cta-button {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 20px;
      background-color: #000000;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #999;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <h1>🛍️ Novidades da nossa loja!</h1>
    <p>Confira os lançamentos da nova coleção:</p>

    <div class="product">
      <img src="http://localhost/Tcc-Web/assets/img/vestidoFloral.jpg" alt="Produto 1">
      <div class="product-details">
        <h3>Vestido Floral Elegante</h3>
        <p>Perfeito para o verão ☀️</p>
      </div>
    </div>

    <div class="product">
      <img src="http://localhost/Tcc-Web/assets/img/camisaEstampada.jpg" alt="Produto 2">
      <div class="product-details">
        <h3>Camisa Estampada</h3>
        <p>Estilo e conforto para o dia a dia 🌟</p>
      </div>
    </div>

    <a class="cta-button" href="http://localhost/Tcc-Web/shop.html">Ver todos os produtos</a>

    <div class="footer">
      Você está recebendo este e-mail porque se cadastrou em nossa loja.<br>
      <a href="http://192.168.0.75/Tcc-Web/index.html">Cancelar inscrição</a>
    </div>
  </div>
</body>
</html>
';



    $mail->Body = $corpoEmail;
    $mail->AltBody = 'Confira as novidades no nosso site: http://192.168.0.75/Tcc-Web/index.html.com';

    $mail->send();
echo '
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Newsletter Enviada</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .message-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .message-box h2 {
            color: #28a745;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = "../../index.html";
        }, 4000); // 4 segundos
    </script>
</head>
<body>
    <div class="message-box">
        <h2>✅ Newsletter enviada com sucesso!</h2>
        <p>Você será redirecionado em instantes...</p>
    </div>
</body>
</html>
';

} catch (Exception $e) {
    echo "Erro ao enviar: {$mail->ErrorInfo}";
}

}else{
    header("Location: index.html");
}



?>