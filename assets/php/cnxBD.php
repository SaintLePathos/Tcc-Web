<?php
function conectarBD(){

    $local_servidorBD = "DESKTOP-GB2HS4S";
    $usuario_servidorBD ="sa";
    $senha_servidorBD = "1234";
    $banco_servidorBD = "Loja_Ecommerce";

    try{
        $conectar = new PDO("sqlsrv:server=$local_servidorBD;database=$banco_servidorBD",$usuario_servidorBD,$senha_servidorBD);
        //echo "Conexao bem sucedida";
        return $conectar;
    }catch(Exception $erro){
        echo "Erro na Conexao: " . $erro->getMessage();
    }

}

$conectar = conectarBD();
?>