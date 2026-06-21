<?php

$servidor = "192.168.0.104";
$usuario = "doceria";
$senha = "123456";
$banco = "imperiodosdoces";
$porta = 3306;

$conexao = new mysqli($servidor, $usuario, $senha, $banco, $porta);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}