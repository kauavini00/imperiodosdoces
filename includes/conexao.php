<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "imperiodosdoces";
$porta = 3306;

try {
    $pdo = new PDO(
        "mysql:host=$servidor;port=$porta;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    die("Erro na conexao: " . $erro->getMessage());
}