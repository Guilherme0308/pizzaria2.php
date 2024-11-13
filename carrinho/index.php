<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: /login"); // Redireciona para a página de login
    exit;
}

// Função para atualizar o carrinho
function atualizarCarrinho() {
    // Verifica se foi feita alguma alteração no carrinho via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Atualizar quantidade do produto
        if (isset($_POST['produto_id']) && isset($_POST['quantidade'])) {
            $produto_id = $_POST['produto_id'];
            $quantidade = $_POST['quantidade'];

            // Se a quantidade for válida, atualiza o carrinho
            if ($quantidade > 0) {
                $_SESSION['carrinho'][$produto_id]['quantidade'] = $quantidade;
            } else {
                // Remove o produto caso a quantidade seja zero
                unset($_SESSION['carrinho'][$produto_id]);
            }
        }

        // Remover produto
        if (isset($_POST['remover_produto_id'])) {
            unset($_SESSION['carrinho'][$_POST['remover_produto_id']]);
        }
    }
}

// Atualiza o carrinho com base nas ações de POST (quantidade ou remoção)
atualizarCarrinho();

// Gerar o conteúdo do carrinho
$page_article = ''; // Certifique-se de que $page_article esteja inicializado
if (!empty($_SESSION['carrinho'])) {
    $total = 0;
    $page_article .= '<div class="carrinho">';
    
    foreach ($_SESSION['carrinho'] as $produto_id => $produto) {
        $produto_total = $produto['preco'] * $produto['quantidade'];
        $total += $produto_total;

        $page_article .= '<div class="produto-carrinho">';
        $page_article .= '<img src="' . $produto['imagem'] . '" alt="' . $produto['nome'] . '" class="produto-imagem">';
        $page_article .= '<h2>' . $produto['nome'] . '</h2>';
        $page_article .= '<p>Preço unitário: R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
        $page_article .= '<div class="quantidade">';

        // Formulário para atualizar a quantidade do produto
        $page_article .= '<form method="POST" class="quantidade-form">';
        $page_article .= '<input type="hidden" name="produto_id" value="' . $produto_id . '">';
        $page_article .= '<button type="submit" name="quantidade" value="' . ($produto['quantidade'] - 1) . '" class="menos">-</button>';
        $page_article .= '<input type="number" name="quantidade" value="' . $produto['quantidade'] . '" min="1" class="quantidade-input">';
        $page_article .= '<button type="submit" name="quantidade" value="' . ($produto['quantidade'] + 1) . '" class="mais">+</button>';
        $page_article .= '</form>';

        $page_article .= '</div>';
        $page_article .= '<p>Total: R$ ' . number_format($produto_total, 2, ',', '.') . '</p>';

        // Formulário para remover produto
        $page_article .= '<form method="POST" class="remover-form">';
        $page_article .= '<input type="hidden" name="remover_produto_id" value="' . $produto_id . '">';
        $page_article .= '<button type="submit" class="remover">Remover</button>';
        $page_article .= '</form>';

        $page_article .= '</div>';
    }

    $page_article .= '<p class="total">Total: R$ ' . number_format($total, 2, ',', '.') . '</p>';
    $page_article .= '<a href="/checkout" class="btn-checkout">Finalizar Compra</a>';
    $page_article .= '</div>';
} else {
    $page_article .= '<p class="vazio">Seu carrinho está vazio.</p>';
}

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
echo "<article>{$page_article}</article>";
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
?>