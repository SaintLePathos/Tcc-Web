<?php
if ($_POST) {
    include(__DIR__ . "/cnxBD.php");
    try {
        $id_produto = $_POST["produto"];
        $comandoSQL = "SELECT * FROM Produto WHERE Id_Produto = :id";
        $sql = $conectar->prepare($comandoSQL);
        $sql->bindValue(":id", $id_produto);
        $sql->execute();
        $resul = $sql->fetch(PDO::FETCH_ASSOC); // só um resultado esperado

        if ($resul) {
            // Buscar imagens do produto
            $novosql = $conectar->prepare("SELECT * FROM Imagem_Produto WHERE Id_Produto = :id ORDER BY Ordem_ImgProduto ASC;");
            $novosql->bindValue(":id", $resul["Id_Produto"]);
            $novosql->execute();
            $resultado = $novosql->fetchAll(PDO::FETCH_ASSOC);

            $imagens = [];
            foreach ($resultado as $cont) {
                $imagens[] = $cont["Url_ImgProduto"];
            }

            $retorno = [
                "id" => $resul["Id_Produto"],
                "nome" => $resul["Nome_Produto"],
                "imagens" => $imagens,
                "descricao" => $resul["Descricao_Produto"],
                "valor" => number_format($resul["Valor_Produto"], 2, '.', ''),
                "desconto" => $resul["Desconto_Produto"],
                "tamanho" => $resul["Tamanho_Produto"],
                "quantidade" => $resul["Quantidade_Produto"],
                "tecido" => $resul["Tecido_Produto"],
                "cor" => $resul["Cor_Produto"]
            ];

            die(json_encode($retorno, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            throw new Exception("Nenhum resultado encontrado");
        }

    } catch (Exception $erro) {
        error_log("Erro na consulta: " . $erro->getMessage());
        echo json_encode(["erro" => "Erro na consulta, tente novamente!"]);
    }
}
?>
