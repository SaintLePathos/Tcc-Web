<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (isset($_FILES['file'])) {
    // Caminho no servidor (para salvar o arquivo)
    $uploadDir = "../../uploads/imgProduto/";

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid() . "_" . basename($_FILES["file"]["name"]);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
        // Caminho relativo PARA O SITE (sem ../../)
        $publicPath = "uploads/imgProduto/" . $fileName;

        echo json_encode([
            "status" => "ok",
            "path" => $publicPath // Caminho correto salvo no banco
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Falha ao mover o arquivo."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Nenhum arquivo recebido."
    ]);
}
?>
