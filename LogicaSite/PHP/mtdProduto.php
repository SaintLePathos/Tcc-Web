<?php
    include(__DIR__."/cnxBD.php");

$tabela = "Produto";

try{
    $comandoSQL = "SELECT * FROM ".$tabela.";";

    $sql = $conectar->prepare($comandoSQL);
	$sql->execute();
    $resul = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($resul) >0){
        foreach($resul as $indice => $conteudo){
            $retorno[$indice] = [
                "nome" => $conteudo["Nome"],
                "tipo" => $conteudo["Tipo"],
                "quantidade" => $conteudo["Quantidade"],
                "descricao" => $conteudo["Descricao"],
                "valor" => $conteudo["Valor"],
                "peso" => $conteudo["Peso"]
            ];
        }
        die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}
	else{
        throw new Exception("Nenhum resultado encontrado");
	};
}	
catch(Exception $erro){
	echo "ATENÇÃO, erro na consulta: " . $erro->getmessage();;
};

?>