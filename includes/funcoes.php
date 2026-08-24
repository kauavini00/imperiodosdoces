<?php

function formatarPreco($preco) {
    return "R$ " . number_format($preco, 2, ",", ".");
}

function buscarProdutoPorId($produtos, $id) {
    foreach ($produtos as $produto) {
        if ($produto["id"] == $id) {
            return $produto;
        }
    }

    return null;
}

function calcularTotal($preco, $quantidade) {
    return $preco * $quantidade;
}

function produtoEmPromocao($preco) {
    if ($preco >= 10) {
        return true;
    }

    return false;
}