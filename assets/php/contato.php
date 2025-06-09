<?php 
date_default_timezone_set('America/Sao_Paulo');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


include("cnxBD.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = strip_tags(trim($_POST['nome']));
    $email = $_POST['email'] ;
    $assunto = strip_tags($_POST['assunto']) ;
    $mensagem = strip_tags($_POST['mensagem']) ;

    $mail = new PHPMailer(true);

    
    $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
    
    if(!$nome || !$email || !$assunto || !$mensagem){
        exit("Todos os campos obrigatórios devem ser preenchidos");
    }


    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        echo 'E-mail inválido';
    }
    



    try {
        // Configurações do SMTP (seu e-mail)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // exemplo: smtp.gmail.com
        $mail->SMTPAuth   = true;
        $mail->Username   = 'diegodouglas452@gmail.com';
        $mail->Password   = 'ztom lyvi tubw rfbe';
        $mail->SMTPSecure =  PHPMailer::ENCRYPTION_SMTPS;  
        $mail->Port   = 465;                                   
        $mail->CharSet = 'UTF-8';

        // Remetente e destinatário
        $mail->setFrom('diegodouglas452@gmail.com', 'Tardigrado');
        $mail->addAddress('diegodouglas452@gmail.com', 'Tardigrado');

        // Responder para o cliente
        $mail->addReplyTo($email, $nome);

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = "
            <strong>Nome:</strong> {$nome}<br>
            <strong>Email:</strong> {$email}<br><br>
            <strong>Mensagem:</strong><br>
            " . nl2br(htmlspecialchars($mensagem));

        $mail->AltBody = "Nome: $nome\nEmail: $email\n\nMensagem:\n$mensagem";

        $mail->send();
        echo "<script>alert('Mensagem enviada com sucesso!'); window.location.href='../../contact.html';</script>";
    } catch (Exception $e) {
        echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
    }
}
?>

?>