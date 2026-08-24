<?php
if (!isset($tituloPagina)) {
    $tituloPagina = "Império dos Doces";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="assets/img/coroa-logo.png">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark menu-principal">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
    <img src="assets/img/coroa-logo.png" alt="Coroa" class="logo-coroa-menu">
    Império dos Doces
</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuSite">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuSite">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="cardapio.php">Cardápio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="carrinho.php">Carrinho</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contato.php">Contato</a>
                </li>               
                </ul>
                    <form class="d-flex ms-lg-3 mt-3 mt-lg-0" action="cardapio.php" method="GET">
                    <input class="form-control me-2" type="search" name="busca" placeholder="Buscar doce">
                    <button class="btn btn-warning" type="submit">Buscar</button>
            </form>
        </div>
    </div>
</nav>
