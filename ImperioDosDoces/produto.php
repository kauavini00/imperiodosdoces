<?php
session_start();

$tituloPagina = "Produto - Império dos Doces";
include "data/produtos_banco.php";
include "includes/funcoes.php";

$id = 0;

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

$produto = buscarProdutoPorId($produtos, $id);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $produto != null) {
    $quantidade = $_POST["quantidade"];

    if ($quantidade > 0) {
        $_SESSION["carrinho"][] = [
            "id" => $produto["id"],
            "nome" => $produto["nome"],
            "preco" => $produto["preco"],
            "quantidade" => $quantidade
        ];

        header("Location: carrinho.php");
        exit;
    }
}

include "includes/header.php";
?>

<main class="container my-5">
    <?php if ($produto == null) { ?>
        <div class="alert alert-danger">
            Produto não encontrado.
        </div>

        <a href="cardapio.php" class="btn btn-warning">Voltar ao cardápio</a>
    <?php } else { ?>
        <div class="row align-items-center g-4">
            <div class="col-md-6">
                <div class="produto-detalhe-imagem">
                    <img src="assets/img/<?= $produto["imagem"]; ?>" alt="<?= $produto["nome"]; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <span class="badge text-bg-warning mb-3"><?= $produto["categoria"]; ?></span>
                <h1><?= $produto["nome"]; ?></h1>
                <p class="lead"><?= $produto["descricao"]; ?></p>
                <h3 class="text-success"><?= formatarPreco($produto["preco"]); ?></h3>

                <?php if (produtoEmPromocao($produto["preco"])) { ?>
                    <div class="alert alert-success mt-3">
                        Esse é um produto especial da casa.
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info mt-3">
                        Esse é um doce tradicional do nosso cardápio.
                    </div>
                <?php } ?>

                <form class="mt-4" method="POST">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" class="form-control mb-3" id="quantidade" name="quantidade" min="1" value="1">

                    <button type="submit" class="btn btn-warning">Adicionar ao carrinho</button>
                    <a href="cardapio.php" class="btn btn-outline-primary">Voltar</a>
                </form>
            </div>
        </div>
    <?php } ?>
</main>

<?php include "includes/footer.php"; ?>