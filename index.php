<?php
$tituloPagina = "Inicio - Imperio dos Doces";
include "data/produtos_banco.php";
include "includes/funcoes.php";
include "includes/header.php";
?>

<section class="banner-principal">
    <div class="container text-center">
        <div class="conteudo-banner">
<h1>
    <img src="assets/img/coroa-logo.png" alt="Coroa" class="logo-coroa-banner">
    Império dos Doces
</h1>
            <p> Um Reino de Sabor, Feitos para adoçar seu dia </p>
            <a href="cardapio.php" class="btn btn-warning btn-lg">Ver cardápio</a>
        </div>
    </div>
</section>

<main class="container my-5">
    <section class="text-center mb-5">
        <h2>Nossos destaques</h2>
        <p class="text-muted">Conheça alguns dos doces mais pedidos da nossa doceria.</p>
    </section>

    <div class="row g-4">
        <?php
        $contador = 0;

        foreach ($produtos as $produto) {
            if ($contador < 3) {
        ?>
                <div class="col-md-4">
                    <div class="card h-100 card-doce">
                        <img src="assets/img/<?= $produto["imagem"]; ?>" class="card-img-top imagem-card-doce" alt="<?= $produto["nome"]; ?>">
                        <div class="card-body">
                            <span class="badge text-bg-warning mb-2"><?= $produto["categoria"]; ?></span>
                            <h5 class="card-title"><?= $produto["nome"]; ?></h5>
                            <p class="card-text"><?= $produto["descricao"]; ?></p>
                            <p class="fw-bold"><?= formatarPreco($produto["preco"]); ?></p>
                            <a href="produto.php?id=<?= $produto["id"]; ?>" class="btn btn-outline-primary">Ver detalhes</a>
                        </div>
                    </div>
                </div>
        <?php
            }

            $contador++;
        }
        ?>
    </div>
</main>

<?php include "includes/footer.php"; ?>
