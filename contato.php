<?php
$tituloPagina = "Contato - Império dos Doces";
include "includes/header.php";

$mensagem = "";
$tipoAlerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $mensagemCliente = trim($_POST["mensagem"]);

    if ($nome == "" || $email == "" || $mensagemCliente == "") {
        $mensagem = "Preencha todos os campos antes de enviar.";
        $tipoAlerta = "danger";
    } else {
        $mensagem = "Mensagem enviada com sucesso! Em breve entraremos em contato.";
        $tipoAlerta = "success";
    }
}
?>

<main class="container my-5">
    <section class="text-center mb-4">
        <h1>Contato</h1>
        <p class="text-muted">Fale com o Império dos Doces para encomendas, dúvidas e sugestões.</p>
    </section>

    <?php if ($mensagem != "") { ?>
        <div class="alert alert-<?= $tipoAlerta; ?>">
            <?= $mensagem; ?>
        </div>
    <?php } ?>

    <div class="row g-4">
        <div class="col-md-6">
            <form method="POST" class="formulario-contato">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <div class="mb-3">
                    <label for="mensagem" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="mensagem" name="mensagem" rows="5"></textarea>
                </div>

                <button type="submit" class="btn btn-warning">Enviar mensagem</button>
            </form>
        </div>

        <div class="col-md-6">
            <div class="caixa-contato">
                <h3>Atendimento</h3>
                <p><strong>WhatsApp:</strong> (44) 99827-9656</p>
                <p><strong>WhatsApp:</strong> (44) 997154576</p>
                <p><strong>E-mail:</strong> ImperiodosDocesOne@gmail.com </p>
                <p><strong>Horário:</strong> Segunda a sábado, das 9h às 18h.</p>

                <div class="alert alert-warning mt-4">
                    Trabalhamos com encomendas de doces para festas, presentes e datas especiais.
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "includes/footer.php"; ?>