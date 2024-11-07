<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

$page_article = '<h1>Carrinho de Compras</h1>';

if (!empty($_SESSION['carrinho'])) {
    $total = 0;
    $page_article .= '<div class="carrinho">';
    foreach ($_SESSION['carrinho'] as $produto_id => $produto) {
        $page_article .= '<div class="produto-carrinho">';
        $page_article .= '<img src="' . $produto['imagem'] . '" alt="' . $produto['nome'] . '" class="produto-imagem">';
        $page_article .= '<h2>' . $produto['nome'] . '</h2>';
        $page_article .= '<p>Preço unitário: R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
        $page_article .= '<div class="quantidade">';
        $page_article .= '<button class="menos" data-produto="' . $produto_id . '">-</button>';
        $page_article .= '<input type="number" value="' . $produto['quantidade'] . '" data-produto="' . $produto_id . '" class="quantidade-input">';
        $page_article .= '<button class="mais" data-produto="' . $produto_id . '">+</button>';
        $page_article .= '</div>';
        $page_article .= '<p>Total: R$ ' . number_format($produto['preco'] * $produto['quantidade'], 2, ',', '.') . '</p>';
        $page_article .= '<button class="remover" data-produto="' . $produto_id . '">Remover</button>';
        $page_article .= '</div>';
        $total += $produto['preco'] * $produto['quantidade'];
    }
    $page_article .= '<p class="total">Total: R$ ' . number_format($total, 2, ',', '.') . '</p>';
    $page_article .= '<a href="/checkout" class="btn-checkout">Finalizar Compra</a>';
    $page_article .= '</div>';
} else {
    $page_article .= '<p>Seu carrinho está vazio.</p>';
}

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

echo "<article>{$page_article}</article>";
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
?>