<?php
$tituloPagina = "Cardápio - Império dos Doces";

include "data/produtos_banco.php";
include "includes/funcoes.php";
include "includes/header.php";

$busca = "";

if (isset($_GET["busca"])) {
    $busca = $_GET["busca"];
}
?>

<main class="container my-5">
    <section class="text-center mb-4">
        <h1>Cardápio</h1>
        <p class="text-muted">Escolha seu doce favorito no Império dos Doces.</p>
    </section>

    <form class="row justify-content-center mb-4" method="GET" action="cardapio.php">
    <div class="col-md-6">
        <input
            type="search"
            name="busca"
            class="form-control"
            placeholder="Digite o nome ou categoria do doce"
            value="<?= $busca; ?>"
        >
    </div>

    <div class="col-md-2 mt-2 mt-md-0">
        <button type="submit" class="btn btn-warning w-100">Buscar</button>
    </div>
</form>

    <?php if ($busca != "") { ?>
    <div class="alert alert-warning d-flex justify-content-between align-items-center">
        <span>Resultado da busca por: <strong><?= $busca; ?></strong></span>
        <a href="cardapio.php" class="btn btn-sm btn-outline-dark">Limpar</a>
    </div>
<?php } ?>

    <div class="row g-4">
        <?php
        $encontrouProduto = false;

        foreach ($produtos as $produto) {
            $nomeProduto = strtolower($produto["nome"]);
            $categoriaProduto = strtolower($produto["categoria"]);
            $termoBusca = strtolower($busca);

            if ($busca == "" || str_contains($nomeProduto, $termoBusca) || str_contains($categoriaProduto, $termoBusca)) {
                $encontrouProduto = true;
        ?>
                <div class="col-md-4">
                    <div class="card h-100 card-doce">
                        <img src="assets/img/<?= $produto["imagem"]; ?>" class="card-img-top imagem-card-doce" alt="<?= $produto["nome"]; ?>">
                        <div class="card-body">
                            <span class="badge text-bg-warning mb-2"><?= $produto["categoria"]; ?></span>
                            <h5 class="card-title"><?= $produto["nome"]; ?></h5>
                            <p class="card-text"><?= $produto["descricao"]; ?></p>
                            <p class="fw-bold"><?= formatarPreco($produto["preco"]); ?></p>

                            <?php if (produtoEmPromocao($produto["preco"])) { ?>
                                <p class="text-success fw-bold">Produto especial da casa</p>
                            <?php } else { ?>
                                <p class="text-muted">Doce tradicional</p>
                            <?php } ?>

                            <a href="produto.php?id=<?= $produto["id"]; ?>" class="btn btn-outline-primary">Ver detalhes</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <?php if (!$encontrouProduto) { ?>
        <div class="alert alert-danger mt-4">
            Nenhum produto encontrado.
        </div>
    <?php } ?>
</main>

<?php include "includes/footer.php"; ?>