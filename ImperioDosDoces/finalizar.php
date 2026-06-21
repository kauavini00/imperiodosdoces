<?php
session_start();

$tituloPagina = "Finalizar Pedido - Império dos Doces";
include "includes/conexao.php";
include "includes/funcoes.php";

$carrinho = [];

if (isset($_SESSION["carrinho"])) {
    $carrinho = $_SESSION["carrinho"];
}

$totalPedido = 0;

foreach ($carrinho as $item) {
    $totalPedido += calcularTotal($item["preco"], $item["quantidade"]);
}

$mensagem = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];

    if ($nome == "" || $telefone == "" || $endereco == "") {
        $erro = "Preencha todos os campos para finalizar o pedido.";
    } elseif (empty($carrinho)) {
        $erro = "Seu carrinho está vazio.";
    } else {
        $sqlPedido = "INSERT INTO pedidos (nm_cliente, nr_telefone, ds_endereco, vl_total)
                      VALUES (?, ?, ?, ?)";

        $stmtPedido = $conexao->prepare($sqlPedido);
        $stmtPedido->bind_param("sssd", $nome, $telefone, $endereco, $totalPedido);
        $stmtPedido->execute();

        $idPedido = $conexao->insert_id;

        foreach ($carrinho as $item) {
            $subtotal = calcularTotal($item["preco"], $item["quantidade"]);

            $sqlItem = "INSERT INTO itens_pedido
                        (id_pedido, id_produto, qt_produto, vl_preco_unitario, vl_subtotal)
                        VALUES (?, ?, ?, ?, ?)";

            $stmtItem = $conexao->prepare($sqlItem);
            $stmtItem->bind_param(
                "iiidd",
                $idPedido,
                $item["id"],
                $item["quantidade"],
                $item["preco"],
                $subtotal
            );
            $stmtItem->execute();
        }

        unset($_SESSION["carrinho"]);

        $mensagem = "Pedido finalizado com sucesso! Entraremos em contato pelo WhatsApp.";
        $carrinho = [];
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
            <a href="cardapio.php" class="btn btn-warning">Voltar ao cardápio</a>
        </div>
    <?php } else { ?>

        <?php if ($erro != "") { ?>
            <div class="alert alert-danger">
                <?= $erro; ?>
            </div>
        <?php } ?>

        <?php if (empty($carrinho)) { ?>
            <div class="alert alert-warning text-center">
                Seu carrinho está vazio.
            </div>

            <div class="text-center">
                <a href="cardapio.php" class="btn btn-warning">Ver cardápio</a>
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
                            <label class="form-label">Endereço</label>
                            <textarea name="endereco" class="form-control" rows="4" placeholder="Digite seu endereço completo"></textarea>
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