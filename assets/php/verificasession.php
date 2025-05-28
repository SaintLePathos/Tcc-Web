<?php
if ($_POST) {
    session_start();

    if (isset($_SESSION['email'])) {
         include("cnxBD.php");

        $email = $_SESSION['email'];
        $tabela = "Cliente";

        $sql = $conectar->prepare("SELECT Nome_Cliente, Email_Cliente, Img_Perfil_Cliente FROM $tabela WHERE Email_Cliente = :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo json_encode([
                'status' => true,
                'dados' => [
                    'nome' => $usuario['Nome_Cliente'],
                    'email' => $usuario['Email_Cliente'],
                    'img' =>  !empty($usuario['Img_Perfil_Cliente']) ? htmlspecialchars($usuario['Img_Perfil_Cliente']) : 'assets/img/perfilpadrao.png'
                ]
            ]);
        } else {
            echo json_encode(['status' => false]);
        }
    } else {
        echo json_encode(['status' => false]);
    }
}
?>
