<?php 
session_start();
include("cnxBD.php");

if (isset($_SESSION['email'])) {
    $email_sessao = $_SESSION['email'];

    $sql = $conectar->prepare("SELECT Id_Cliente FROM Cliente WHERE Email_Cliente = :email");
    $sql->bindValue(":email", $email_sessao);
    $sql->execute();

    $id = $sql->fetch(PDO::FETCH_ASSOC);

    if ($id && isset($id["Id_Cliente"])) {
        $oid = $id["Id_Cliente"];

        $query = "
            SELECT 
                p.Id_Pedido,
                p.Data_Pedido,
                p.Status_Pedido,
                ISNULL(SUM(pp.Quantidade_Produto_Pedido * pp.Valor_Produto_Pedido), 0) AS Total
            FROM Pedido p
            JOIN Endereco_Cliente ec ON ec.Id_Endereco_Cliente = p.Id_Endereco_Cliente
            JOIN Produto_Pedido pp ON pp.Id_Pedido = p.Id_Pedido
            WHERE ec.Id_Cliente = :id
            GROUP BY p.Id_Pedido, p.Data_Pedido, p.Status_Pedido
            ORDER BY p.Data_Pedido DESC
        ";

        $pedido = $conectar->prepare($query);
        $pedido->bindValue(":id", $oid);
        $pedido->execute();
        $pedidos = $pedido->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Meus Pedidos</title>
            <style>
                * {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                }

                body {
                    font-family: 'Segoe UI', sans-serif;
                    background-color: #f8f8fc;
                    color: #121212;
                    padding: 40px 20px;
                }

                .container {
                    max-width: 900px;
                    margin: auto;
                    background-color: #ffffff;
                    padding: 30px;
                    border-radius: 12px;
                    box-shadow: 0 0 15px rgba(0,0,0,0.05);
                }

                .voltar {
                    display: inline-block;
                    margin-bottom: 30px;
                    text-decoration: none;
                    color: #121212;
                    font-weight: 500;
                    border: 1px solid #121212;
                    padding: 8px 18px;
                    border-radius: 8px;
                    transition: all 0.3s ease;
                }

                .voltar:hover {
                    background-color: #121212;
                    color: #fff;
                }

                h2 {
                    font-size: 28px;
                    margin-bottom: 30px;
                    text-align: center;
                }

                .pedido {
                    border: 1px solid #e0e0e0;
                    border-radius: 10px;
                    padding: 20px;
                    margin-bottom: 25px;
                    background-color: #fafafa;
                }

                .pedido p {
                    margin: 8px 0;
                }

                .pedido strong {
                    color: #333;
                }

                .btn-pdf {
                    margin-top: 12px;
                    padding: 10px 20px;
                    background-color: #000;
                    color: #fff;
                    border: none;
                    border-radius: 8px;
                    font-weight: bold;
                    cursor: pointer;
                    transition: background 0.3s ease;
                }

                .btn-pdf:hover {
                    background-color: #333;
                }

                @media (max-width: 600px) {
                    .container {
                        padding: 20px;
                    }

                    .btn-pdf, .voltar {
                        width: 100%;
                        text-align: center;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <a href="../../index.html" class="voltar">← Voltar</a>
                <h2>Seus Pedidos</h2>

                <?php if (!empty($pedidos)): ?>
                    <?php foreach ($pedidos as $p): ?>
                        <div class="pedido">
                            <p><strong>Nº Pedido:</strong> <?= htmlspecialchars($p["Id_Pedido"]) ?></p>
                            <p><strong>Data:</strong> <?= date("d/m/Y", strtotime($p["Data_Pedido"])) ?></p>
                            <p><strong>Status:</strong> <?= $p["Status_Pedido"] ? "Em preparação" : "Pronto" ?></p>
                            <p><strong>Total:</strong> R$ <?= number_format($p["Total"], 2, ',', '.') ?></p>
                            <form method="POST" action="gerar_pdf.php" target="_blank">
                                <input type="hidden" name="id_pedido" value="<?= htmlspecialchars($p["Id_Pedido"]) ?>">
                                <button type="submit" class="btn-pdf">Imprimir PDF</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Você ainda não fez nenhum pedido.</p>
                <?php endif; ?>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Cliente não encontrado
        header("Location: ../../login.php");
        exit;
    }
} else {
    // Usuário não logado
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Acesso Negado</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #f8f8fc;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                color: #121212;
            }

            .mensagem-container {
                background-color: #fff;
                padding: 40px;
                border-radius: 12px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 400px;
                width: 90%;
            }

            .mensagem-container h2 {
                margin-bottom: 15px;
                font-size: 24px;
            }

            .mensagem-container p {
                margin-bottom: 25px;
                color: #555;
            }

            .botao-voltar {
                display: inline-block;
                padding: 10px 20px;
                background-color: #000;
                color: #fff;
                text-decoration: none;
                border-radius: 8px;
                transition: background 0.3s ease;
            }

            .botao-voltar:hover {
                background-color: #333;
            }
        </style>
    </head>
    <body>
        <div class="mensagem-container">
            <h2>Acesso negado</h2>
            <p>Você precisa estar logado para visualizar seus pedidos.</p>
            <a href="../../login.php" class="botao-voltar">Voltar ao login</a>
        </div>
    </body>
    </html>
    <?php
}
?>
