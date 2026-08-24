<?php
$tituloPagina = "Dashboard - Imperio dos Doces";
$scriptPagina = "assets/js/dashboard.js";
include "includes/header.php";
?>

<main class="container my-5">
    <section class="text-center mb-4">
        <h1>Dashboard Administrativo</h1>
        <p class="text-muted">Resumo dos produtos e pedidos do Imperio dos Doces.</p>
    </section>

    <div id="mensagemErro" class="alert alert-danger d-none"></div>

    <section class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <p class="text-muted mb-1">Total vendido</p>
                    <h3 id="totalVendido">R$ 0,00</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <p class="text-muted mb-1">Pedidos</p>
                    <h3 id="totalPedidos">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <p class="text-muted mb-1">Produtos</p>
                    <h3 id="totalProdutos">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <p class="text-muted mb-1">Doces vendidos</p>
                    <h3 id="totalDocesVendidos">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard">
                <div class="card-body">
                    <p class="text-muted mb-1">Destaque</p>
                    <h5 id="produtoDestaque">Sem vendas</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-md-7">
            <div class="card card-dashboard">
                <div class="card-header bg-warning fw-bold">
                    Produtos do cardapio
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Preco</th>
                                </tr>
                            </thead>
                            <tbody id="tabelaProdutos"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-dashboard">
                <div class="card-header bg-warning fw-bold">
                    Produtos especiais
                </div>
                <div class="card-body">
                    <ul id="listaProdutosEspeciais" class="list-group"></ul>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-dashboard">
                <div class="card-header bg-warning fw-bold">
                    Produtos mais pedidos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade vendida</th>
                                </tr>
                            </thead>
                            <tbody id="tabelaMaisPedidos"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include "includes/footer.php"; ?>
