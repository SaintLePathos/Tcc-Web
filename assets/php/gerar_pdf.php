<?php
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include("cnxBD.php");

if (isset($_POST['id_pedido'])) {
    $id_pedido = $_POST['id_pedido'];

    // Buscar dados do pedido
    $sql = $conectar->prepare("
        SELECT 
            p.Id_Pedido,
            p.Data_Pedido,
            p.Status_Pedido,
            c.Nome_Cliente,
            ec.Rua_Cliente, ec.Numero_Cliente, ec.Bairro_Cliente, ec.Cidade_Cliente, ec.Estado_Cliente, ec.CEP_Cliente
        FROM Pedido p
        JOIN Endereco_Cliente ec ON ec.Id_Endereco_Cliente = p.Id_Endereco_Cliente
        JOIN Cliente c ON c.Id_Cliente = ec.Id_Cliente
        WHERE p.Id_Pedido = :id
    ");
    $sql->bindValue(":id", $id_pedido);
    $sql->execute();
    $pedido = $sql->fetch(PDO::FETCH_ASSOC);

    // Buscar produtos com imagem
    $prod = $conectar->prepare("
        SELECT 
            pr.Nome_Produto, 
            pp.Quantidade_Produto_Pedido, 
            pp.Valor_Produto_Pedido,
            (SELECT TOP 1 Url_ImgProduto FROM Imagem_Produto WHERE Id_Produto = pr.Id_Produto ORDER BY Ordem_ImgProduto) AS Imagem
        FROM Produto_Pedido pp
        JOIN Produto pr ON pr.Id_Produto = pp.Id_Produto
        WHERE pp.Id_Pedido = :id
    ");
    $prod->bindValue(":id", $id_pedido);
    $prod->execute();
    $produtos = $prod->fetchAll(PDO::FETCH_ASSOC);

    // HTML para o PDF
    ob_start();
    ?>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .img-produto {
            width: 60px;
            height: auto;
        }
    </style>

    <h2>Pedido Nº <?= $pedido["Id_Pedido"] ?></h2>
    <p><strong>Data:</strong> <?= date("d/m/Y", strtotime($pedido["Data_Pedido"])) ?></p>
    <p><strong>Status:</strong> <?= $pedido["Status_Pedido"] ? "Em preparação" : "Pronto" ?></p>
    <p><strong>Usuário:</strong> <?= $pedido["Nome_Cliente"] ?></p>
    <p><strong>Endereço:</strong>
        <?= $pedido["Rua_Cliente"] ?>, <?= $pedido["Numero_Cliente"] ?> -
        <?= $pedido["Bairro_Cliente"] ?>, <?= $pedido["Cidade_Cliente"] ?>/<?= $pedido["Estado_Cliente"] ?> -
        CEP: <?= $pedido["CEP_Cliente"] ?>
    </p>

    <h3>Produtos</h3>
    <table>
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($produtos as $item): 
                $subtotal = $item['Quantidade_Produto_Pedido'] * $item['Valor_Produto_Pedido'];
                $total += $subtotal;

                // Caminho completo da imagem
                $imgPath = $item['Imagem'] 
                    ? 'http://192.168.0.75/Tcc-Web/' . $item['Imagem'] // ajuste conforme o caminho real
                    : '';
            ?>
            <tr>
                <td>
                    <?php if ($imgPath): ?>
                        <img src="<?= $imgPath ?>" class="img-produto">
                    <?php else: ?>
                        Sem imagem
                    <?php endif; ?>
                </td>
                <td><?= $item['Nome_Produto'] ?></td>
                <td><?= $item['Quantidade_Produto_Pedido'] ?></td>
                <td>R$ <?= number_format($item['Valor_Produto_Pedido'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" align="right"><strong>Total Geral:</strong></td>
                <td><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>

    <?php
    $html = ob_get_clean();

    $options = new Options();
    $options->set('isRemoteEnabled', true); // Permite carregar imagens externas

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("pedido_" . $pedido["Id_Pedido"] . ".pdf", ["Attachment" => false]); // abrir no navegador
}
?>
