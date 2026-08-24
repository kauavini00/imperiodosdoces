<?php

header("Content-Type: application/json; charset=utf-8");

try {
    include "../includes/conexao.php";

    $consultaProdutos = $pdo->prepare("SELECT * FROM produtos ORDER BY nm_produto");
    $consultaProdutos->execute();
    $produtos = $consultaProdutos->fetchAll(PDO::FETCH_ASSOC);

    $consultaPedidos = $pdo->prepare("SELECT * FROM vw_resumo_pedidos ORDER BY dt_pedido DESC");
    $consultaPedidos->execute();
    $pedidos = $consultaPedidos->fetchAll(PDO::FETCH_ASSOC);

    $consultaItens = $pdo->prepare("SELECT * FROM itens_pedido");
    $consultaItens->execute();
    $itens = $consultaItens->fetchAll(PDO::FETCH_ASSOC);

    $sqlRanking = "
        WITH vendas_produtos AS (
            SELECT
                pr.id_produto,
                pr.nm_produto,
                SUM(ip.qt_produto) AS total_vendido,
                SUM(ip.vl_subtotal) AS total_faturado
            FROM produtos pr
            LEFT JOIN itens_pedido ip ON ip.id_produto = pr.id_produto
            GROUP BY pr.id_produto, pr.nm_produto
        )
        SELECT *
        FROM vendas_produtos
        ORDER BY total_faturado DESC
    ";

    $consultaRanking = $pdo->prepare($sqlRanking);
    $consultaRanking->execute();
    $ranking = $consultaRanking->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "erro" => false,
        "produtos" => $produtos,
        "pedidos" => $pedidos,
        "itens" => $itens,
        "ranking" => $ranking
    ]);
} catch (Exception $erro) {
    http_response_code(500);

    echo json_encode([
        "erro" => true,
        "mensagem" => "Nao foi possivel carregar os dados do dashboard."
    ]);
}
