<?php
function conectar(){

    $local_server = "COMPUTERNAME\SQLEXPRESS";
    $usuario_server = "sa";
    $senha_server = "1234";
    $banco_de_dados = "Loja_Ecomerce";
    
    try{

        $pdo = new PDO("sqlsrv:server=$local_server;database=$banco_de_dados", $usuario_server, $senha_server);
        return $pdo;

    }catch(Exception $erro){
        echo "ATENÇÃO - ERRO NA CONEXÃO: ".$erro ->getMessage();
        die;
    }

};


?>