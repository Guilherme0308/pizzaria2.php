<?php
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');
// Inicia a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o carrinho já existe na sessão
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$page_article = <<<HTML
<!-- HTML Structure -->
<section class="banner">
    <div class="banner-overlay">
        <a href="carrinho.php" class="banner-button">Fazer Pedido</a>
    </div>
</section>
HTML;

$page_article .= '<section class="pizzas-content">';
$sql = "SELECT id, nome, preco, categoria, descricao, imagem FROM produtos"; // Inclui o ID para identificar o produto
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $page_article .= <<<HTML
            <div class="pizza-card">
                <img src="{$row['imagem']}" alt="{$row['nome']}" class="pizza-image">
                <div class="pizza-info">
                    <h2>{$row['nome']}</h2>
                    <p>Preço: R$ {$row['preco']}</p>
                    <form method="POST" action="adicionar_ao_carrinho.php">
                        <input type="hidden" name="produto_id" value="{$row['id']}">
                        <button type="submit" class="order-button">Adicionar ao carrinho</button>
                    </form>
                </div>
            </div>
        HTML;
    }
} else {
    $page_article .= "<p>Não há produtos disponíveis no momento.</p>";
}

$page_article .= '</section>';

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
echo "<article>{$page_article}</article>";
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
?>