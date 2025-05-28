
<?php
if($_POST){
        include(__DIR__."/cnxBD.php");
    try{



        $ordem = $_POST["ordemjs"];
        $filtroTamanho = isset($_POST["fltTamanhojs"]) ? (array) $_POST["fltTamanhojs"] : ["vazio"];
        $filtroCor = isset($_POST["fltCorjs"]) ? (array) $_POST["fltCorjs"] : ["vazio"];
        $filtroTecido = isset($_POST["fltTecidojs"]) ? (array) $_POST["fltTecidojs"] : ["vazio"];

        //$filtroTamanho[0] = 'vazio';//$_POST["fltTamanhojs"];
        //$filtroCor[0] = 'vazio';//$_POST["fltCorjs"];
        //$filtroTecido[0] = 'vazio';//$_POST["fltTecidojs"];


        switch ($ordem) {
            case "relevante":
                $ord ="Id_Produto DESC";
                break;
            case "novidade":
                $ord ="Id_Produto DESC";
                break;
            case "vendido":
                $ord ="Id_Produto DESC";
                break;
            case "desconto":
                $ord ="Desconto_Produto DESC";
                break;
            case "+preco":
                $ord ="Valor_Produto DESC";
                break;
            case "-preco":
                $ord ="Valor_Produto ASC";
                break;
            case "az":
                $ord ="Nome_Produto ASC";
                break;
            case "za":
                $ord ="Nome_Produto DESC";
                break;
            default:
                $ord = "";
        }
        
        $comandoSQL = "SELECT * FROM Produto ";
        if ($filtroTamanho[0] != "vazio" || $filtroCor[0] != "vazio" || $filtroTecido[0] != "vazio") {
            $comandoSQL .= "ORDER BY CASE ";
            $wre = "WHEN 1=1 "; // Inicia com uma condição sempre verdadeira
            if ($filtroCor[0] != "vazio") {
                $wre .= "AND Cor_Produto IN ('" . implode("','", $filtroCor) . "') ";
            }
            if ($filtroTamanho[0] != "vazio") {
                $wre .= "AND Tamanho_Produto IN ('" . implode("','", $filtroTamanho) . "') ";
            }
            if ($filtroTecido[0] != "vazio") {
                $wre .= "AND Tecido_Produto IN ('" . implode("','", $filtroTecido) . "') ";
            }
            $comandoSQL = $comandoSQL . $wre . "THEN 1 ELSE 2 END, " . $ord;
        }else{
            $comandoSQL = $comandoSQL . "ORDER BY " . $ord;
        }

        $sql = $conectar->prepare($comandoSQL);
        $sql->execute();
        $resul = $sql->fetchAll(PDO::FETCH_ASSOC);
        if (count($resul) >0){
            foreach($resul as $indice => $conteudo){

                $retorno[$indice] = [
                    "id" => $conteudo["Id_Produto"],
                    "nome" => $conteudo["Nome_Produto"],
                    "img" => $conteudo["Img_Produto"],
                    "descricao" => $conteudo["Descricao_Produto"],
                    "valor" => number_format($conteudo["Valor_Produto"], 2, '.', ''),
                    "desconto" => $conteudo["Desconto_Produto"],
                    "tamanho" => $conteudo["Tamanho_Produto"],
                    "quantidade" => $conteudo["Quantidade_Produto"],
                    "tecido" => $conteudo["Tecido_Produto"],
                    "cor" => $conteudo["Cor_Produto"]
                ];
            }
            die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
        else{
            throw new Exception("Nenhum resultado encontrado");
        };
    }	
    catch(Exception $erro){
        error_log("Erro na consulta: ". $comandoSQL . $erro->getMessage()); // Salva erro no log
        echo json_encode(["erro" => "Erro na consulta, tente novamente!" . $comandoSQL]);
    }
    
}
?>