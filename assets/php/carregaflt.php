
<?php
if($_POST){
        include(__DIR__."/cnxBD.php");
    try{
        $flt = $_POST['filtrojs'];
        $filtroSelecionado = '';
        switch ($flt) {
            case 'Tamanho':
                $filtroSelecionado = 'Tamanho_Produto';
                break;
            case 'Cor':
                $filtroSelecionado = 'Cor_Produto';
                break;
            case 'Tecido':
                $filtroSelecionado = 'Tecido_Produto';
                break;
            default:
                # code...
                break;
        }


        
        $comandoSQL = "SELECT $filtroSelecionado, COUNT(*) AS Quantidade FROM Produto GROUP BY $filtroSelecionado ORDER BY $filtroSelecionado ASC;";
        
        $sql = $conectar->prepare($comandoSQL);
        $sql->execute();
        $resul = $sql->fetchAll(PDO::FETCH_ASSOC);
        $estoquesit = "";
        if (count($resul) >0){
            foreach($resul as $indice => $conteudo){

                $retorno[$indice] = [
                    "filtro" => $conteudo["$filtroSelecionado"],
                    "quantidade" => $conteudo["Quantidade"]
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
    }
}
?>