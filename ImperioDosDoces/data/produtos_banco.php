<?php

include "includes/conexao.php";

$sql = "SELECT * FROM produtos";
$resultado = $conexao->query($sql);

$produtos = [];

while ($linha = $resultado->fetch_assoc()) {
    $produtos[] = [
        "id" => $linha["id_produto"],
        "nome" => $linha["nm_produto"],
        "descricao" => $linha["ds_produto"],
        "preco" => $linha["vl_preco"],
        "imagem" => $linha["img_produto"],
        "categoria" => $linha["nm_categoria"]
    ];
}