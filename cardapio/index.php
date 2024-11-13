<?php

// Inclui o arquivo de configuração global do aplicativo:
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');


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
                    <form method="POST" action="/adicionar_ao_carrinho.php">
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
$page_article .= '</section>';

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
echo "<article>{$page_article}</article>";

require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');