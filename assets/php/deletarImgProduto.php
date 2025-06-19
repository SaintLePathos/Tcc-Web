<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = json_decode(file_get_contents("php://input"), true);

    if (!isset($dados['imagem'])) {
        http_response_code(400);
        echo json_encode(["erro" => "Campo 'imagem' não fornecido."]);
        exit;
    }

    $nomeImagem = basename($dados['imagem']); // Segurança básica
    $caminho = "../../uploads/imgProduto/" . $nomeImagem;

    if (file_exists($caminho)) {
        if (unlink($caminho)) {
            echo json_encode(["sucesso" => true]);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao deletar o arquivo."]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["erro" => "Imagem não encontrada."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["erro" => "Método não permitido."]);
}
?>
