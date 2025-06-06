<?php
    if($_POST){
        include(__DIR__."/cnxBD.php");
        try{
            $id_produto = $_POST["produto"];
            $comandoSQL = "SELECT * FROM Produto WHERE Id_Produto = :id";
            $sql = $conectar->prepare($comandoSQL);
            $sql -> bindValue(":id", $id_produto);
            $sql -> execute();
            $resul = $sql->fetchAll(PDO::FETCH_ASSOC);
            if (count($resul) >0){
                foreach($resul as $indice => $conteudo){
                    $novosql = $conectar->prepare("SELECT * FROM Imagem_Produto WHERE Id_Produto = " . $conteudo["Id_Produto"] ." AND Ordem_ImgProduto = 0 ORDER BY Ordem_ImgProduto ASC;");
                    $novosql->execute();
                    $resultado = $novosql->fetchAll(PDO::FETCH_ASSOC);
                    $imagemurl = "";
                    if(count($resultado)>0){
                        foreach($resultado as $i => $cont){
                            $imagemurl =  $cont["Url_ImgProduto"];
                        }
                    }
                    $retorno = [
                        "id" => $conteudo["Id_Produto"],
                        "nome" => $conteudo["Nome_Produto"],
                        "img" => $imagemurl,
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
            die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }catch(Exception $erro){
            error_log("Erro na consulta: " . $erro->getMessage()); // Salva erro no log
            echo json_encode(["erro" => "Erro na consulta, tente novamente!"]);
        }
    }


?>