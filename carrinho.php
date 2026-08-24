<?php
session_start();

$tituloPagina = "Carrinho - Imperio dos Doces";
include "includes/funcoes.php";

if (isset($_GET["limpar"])) {
    unset($_SESSION["carrinho"]);
    header("Location: carrinho.php");
    exit;
}

if (isset($_GET["remover"])) {
    $indiceRemover = $_GET["remover"];

    if (isset($_SESSION["carrinho"][$indiceRemover])) {
        unset($_SESSION["carrinho"][$indiceRemover]);
        $_SESSION["carrinho"] = array_values($_SESSION["carrinho"]);
    }

    header("Location: carrinho.php");
    exit;
}

$carrinho = $_SESSION["carrinho"] ?? [];
$totalPedido = 0;

include "includes/header.php";
?>

<main class="container my-5">
    <section class="text-center mb-4">
        <h1>Carrinho</h1>
        <p class="text-muted">Confira os doces escolhidos antes de finalizar o pedido.</p>
    </section>

    <?php if (empty($carrinho)) { ?>
        <div class="alert alert-warning">
            Seu carrinho esta vazio.
        </div>

        <a href="cardapio.php" class="btn btn-warning">Ver cardapio</a>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-warning">
                    <tr>
                        <th>Produto</th>
                        <th>Preco</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Acao</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($carrinho as $indice => $item) { ?>
                        <?php
                        $totalItem = calcularTotal($item["preco"], $item["quantidade"]);
                        $totalPedido += $totalItem;
                        ?>

                        <tr>
                            <td><?= $item["nome"]; ?></td>
                            <td><?= formatarPreco($item["preco"]); ?></td>
                            <td><?= $item["quantidade"]; ?></td>
                            <td><?= formatarPreco($totalItem); ?></td>
                            <td>
                                <a href="carrinho.php?remover=<?= $indice; ?>" class="btn btn-sm btn-outline-danger">
                                    Remover
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="card card-total-pedido ms-auto">
            <div class="card-body">
                <h4>Total do pedido</h4>
                <p class="fs-4 fw-bold text-success"><?= formatarPreco($totalPedido); ?></p>

                <a href="cardapio.php" class="btn btn-outline-primary">Continuar comprando</a>
                <a href="carrinho.php?limpar=1" class="btn btn-outline-danger">Limpar carrinho</a>
                <a href="finalizar.php" class="btn btn-warning">Finalizar pedido</a>
            </div>
        </div>
    <?php } ?>
</main>

<?php include "includes/footer.php"; ?>
