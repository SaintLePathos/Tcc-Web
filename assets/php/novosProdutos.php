<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include(__DIR__ . "/cnxBD.php");

    try {
        $comandoSQL = "
            SELECT TOP 6
                p.Id_Produto,
                p.Nome_Produto,
                p.Descricao_Produto,
                p.Valor_Produto,
                p.Desconto_Produto,
                p.Tamanho_Produto,
                p.Quantidade_Produto,
                p.Tecido_Produto,
                p.Cor_Produto,
                img.Url_ImgProduto
            FROM Produto p
            OUTER APPLY (
                SELECT TOP 1 Url_ImgProduto
                FROM Imagem_Produto 
                WHERE Id_Produto = p.Id_Produto
                ORDER BY Ordem_ImgProduto ASC
            ) img
            ORDER BY p.Id_Produto DESC;
        ";

        $sql = $conectar->prepare($comandoSQL);
        $sql->execute();
        $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);

        $resultadoFinal = [];

        foreach ($produtos as $produto) {
            $precoOriginal = (float)$produto["Valor_Produto"];
            $desconto = (int)$produto["Desconto_Produto"];
            $precoComDesconto = $precoOriginal - ($precoOriginal * $desconto / 100);

            $resultadoFinal[] = [
                "id" => $produto["Id_Produto"],
                "nome" => $produto["Nome_Produto"],
                "descricao" => $produto["Descricao_Produto"],
                "valor" => number_format($precoComDesconto, 2, '.', ''),
                "valor_original" => number_format($precoOriginal, 2, '.', ''),
                "desconto" => $desconto,
                "tamanho" => $produto["Tamanho_Produto"],
                "quantidade" => $produto["Quantidade_Produto"],
                "tecido" => $produto["Tecido_Produto"],
                "cor" => $produto["Cor_Produto"],
                "imagem" => $produto["Url_ImgProduto"]
            ];
        }

        die(json_encode($resultadoFinal, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    } catch (Exception $erro) {
        error_log("Erro: " . $erro->getMessage());
        echo json_encode(["erro" => "Erro na consulta."]);
    }
}
?>
