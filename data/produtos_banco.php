<?php

include "includes/conexao.php";

$sql = "SELECT * FROM produtos ORDER BY nm_produto";
$consulta = $pdo->prepare($sql);
$consulta->execute();

$produtos = [];
$dadosProdutos = $consulta->fetchAll(PDO::FETCH_ASSOC);

foreach ($dadosProdutos as $linha) {
    $produtos[] = [
        "id" => $linha["id_produto"],
        "nome" => $linha["nm_produto"],
        "descricao" => $linha["ds_produto"],
        "preco" => $linha["vl_preco"],
        "imagem" => $linha["img_produto"],
        "categoria" => $linha["nm_categoria"]
    ];
}
