<?php
session_start();

$tituloPagina = "Finalizar Pedido - Imperio dos Doces";
include "includes/conexao.php";
include "includes/funcoes.php";

$carrinho = $_SESSION["carrinho"] ?? [];
$totalPedido = 0;

foreach ($carrinho as $item) {
    $totalPedido += calcularTotal($item["preco"], $item["quantidade"]);
}

$mensagem = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $endereco = trim($_POST["endereco"] ?? "");

    if ($nome == "" || $telefone == "" || $endereco == "") {
        $erro = "Preencha todos os campos para finalizar o pedido.";
    } elseif (empty($carrinho)) {
        $erro = "Seu carrinho esta vazio.";
    } else {
        try {
            $pdo->beginTransaction();

            $sqlPedido = "INSERT INTO pedidos (nm_cliente, nr_telefone, ds_endereco, vl_total)
                          VALUES (:nome, :telefone, :endereco, :total)";
            $consultaPedido = $pdo->prepare($sqlPedido);
            $consultaPedido->bindParam(":nome", $nome);
            $consultaPedido->bindParam(":telefone", $telefone);
            $consultaPedido->bindParam(":endereco", $endereco);
            $consultaPedido->bindParam(":total", $totalPedido);
            $consultaPedido->execute();

            $idPedido = $pdo->lastInsertId();

            $sqlItem = "INSERT INTO itens_pedido
                        (id_pedido, id_produto, qt_produto, vl_preco_unitario, vl_subtotal)
                        VALUES (:pedido, :produto, :quantidade, :preco, :subtotal)";
            $consultaItem = $pdo->prepare($sqlItem);

            foreach ($carrinho as $item) {
                $subtotal = calcularTotal($item["preco"], $item["quantidade"]);

                $consultaItem->execute([
                    ":pedido" => $idPedido,
                    ":produto" => $item["id"],
                    ":quantidade" => $item["quantidade"],
                    ":preco" => $item["preco"],
                    ":subtotal" => $subtotal
                ]);
            }

            $pdo->commit();
            unset($_SESSION["carrinho"]);

            $mensagem = "Pedido finalizado com sucesso! Entraremos em contato pelo WhatsApp.";
            $carrinho = [];
        } catch (PDOException $e) {
            $pdo->rollBack();
            $erro = "Nao foi possivel finalizar o pedido. Tente novamente.";
        }
    }
}

include "includes/header.php";
?>

<main class="container my-5">
    <h1 class="text-center mb-4">Finalizar Pedido</h1>

    <?php if ($mensagem != "") { ?>
        <div class="alert alert-success text-center">
            <?= $mensagem; ?>
        </div>

        <div class="text-center">
            <a href="cardapio.php" class="btn btn-warning">Voltar ao cardapio</a>
        </div>
    <?php } else { ?>

        <?php if ($erro != "") { ?>
            <div class="alert alert-danger">
                <?= $erro; ?>
            </div>
        <?php } ?>

        <?php if (empty($carrinho)) { ?>
            <div class="alert alert-warning text-center">
                Seu carrinho esta vazio.
            </div>

            <div class="text-center">
                <a href="cardapio.php" class="btn btn-warning">Ver cardapio</a>
            </div>
        <?php } else { ?>

            <div class="row g-4">
                <div class="col-md-7">
                    <form method="POST" class="formulario-contato">
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" placeholder="Digite seu nome">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone" class="form-control" placeholder="Digite seu telefone">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Endereco</label>
                            <textarea name="endereco" class="form-control" rows="4" placeholder="Digite seu endereco completo"></textarea>
                        </div>

                        <button type="submit" class="btn btn-warning">Confirmar pedido</button>
                        <a href="carrinho.php" class="btn btn-outline-secondary">Voltar</a>
                    </form>
                </div>

                <div class="col-md-5">
                    <div class="card-total-pedido">
                        <h4>Resumo do Pedido</h4>

                        <?php foreach ($carrinho as $item) { ?>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><?= $item["nome"]; ?> x<?= $item["quantidade"]; ?></span>
                                <strong><?= formatarPreco(calcularTotal($item["preco"], $item["quantidade"])); ?></strong>
                            </div>
                        <?php } ?>

                        <div class="d-flex justify-content-between mt-3">
                            <h5>Total</h5>
                            <h5><?= formatarPreco($totalPedido); ?></h5>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    <?php } ?>
</main>

<?php include "includes/footer.php"; ?>
