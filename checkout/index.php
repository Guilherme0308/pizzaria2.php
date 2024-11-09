<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho'])) {
    header('Location: /carrinho'); // Redireciona para o carrinho se estiver vazio
    exit();
}

$page_article = '<h1>Finalizar Compra</h1>';

$total = 0;
$page_article .= '<div class="carrinho">';

foreach ($_SESSION['carrinho'] as $produto_id => $produto) {
    $page_article .= '<div class="produto-carrinho">';
    $page_article .= '<img src="' . $produto['imagem'] . '" alt="' . $produto['nome'] . '" class="produto-imagem">';
    $page_article .= '<h2>' . $produto['nome'] . '</h2>';
    $page_article .= '<p>Preço unitário: R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
    $page_article .= '<p>Quantidade: ' . $produto['quantidade'] . '</p>';
    $page_article .= '<p>Total: R$ ' . number_format($produto['preco'] * $produto['quantidade'], 2, ',', '.') . '</p>';
    $page_article .= '</div>';
    $total += $produto['preco'] * $produto['quantidade'];
}

$page_article .= '<p class="total">Total: R$ ' . number_format($total, 2, ',', '.') . '</p>';

$page_article .= '<h3>Dados de Entrega</h3>';
$page_article .= '<form action="/processar-compra.php" method="POST" class="checkout-form">';
$page_article .= '<label for="nome_cliente">Nome Completo:</label>';
$page_article .= '<input type="text" id="nome_cliente" name="nome_cliente" required>';

$page_article .= '<label for="endereco">Endereço de Entrega:</label>';
$page_article .= '<input type="text" id="endereco" name="endereco" required>';

$page_article .= '<label for="cep">CEP:</label>';
$page_article .= '<input type="text" id="cep" name="cep" required>';

$page_article .= '<label for="metodo_pagamento">Método de Pagamento:</label>';
$page_article .= '<select name="metodo_pagamento" id="metodo_pagamento" required>';
$page_article .= '<option value="cartao">Cartão de Crédito</option>';
$page_article .= '<option value="boleto">Boleto Bancário</option>';
$page_article .= '</select>';

$page_article .= '<div id="dados_cartao" style="display: none;">';
$page_article .= '<h3>Informações do Cartão de Crédito</h3>';
$page_article .= '<label for="numero_cartao">Número do Cartão:</label>';
$page_article .= '<input type="text" id="numero_cartao" name="numero_cartao" maxlength="16" pattern="\d{16}" placeholder="XXXX-XXXX-XXXX-XXXX" required>';

$page_article .= '<label for="validade_cartao">Data de Validade (MM/AA):</label>';
$page_article .= '<input type="text" id="validade_cartao" name="validade_cartao" maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/AA" required>';

$page_article .= '<label for="cvv">Código de Segurança (CVV):</label>';
$page_article .= '<input type="text" id="cvv" name="cvv" maxlength="3" pattern="\d{3}" placeholder="CVV" required>';
$page_article .= '</div>';

$page_article .= '<div id="cartao_salvo" style="display: none;">';
$page_article .= '<h3>Cartão de Crédito Salvo</h3>';
$page_article .= '<p>Últimos 4 dígitos: <span id="ultimo_cartao"></span></p>';
$page_article .= '</div>';

$page_article .= '<button type="submit" class="btn-finalizar-compra">Finalizar Compra</button>';
$page_article .= '</form>';

$page_article .= '</div>';

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
echo "<article>{$page_article}</article>";
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
?>

<script>
document.getElementById('metodo_pagamento').addEventListener('change', function() {
    var metodoPagamento = this.value;
    var dadosCartao = document.getElementById('dados_cartao');
    var cartaoSalvo = document.getElementById('cartao_salvo');
    
    if (metodoPagamento === 'cartao') {
        dadosCartao.style.display = 'block';
        cartaoSalvo.style.display = 'none';
    } else {
        dadosCartao.style.display = 'none';
        cartaoSalvo.style.display = 'none';
    }
});

// Verificar se já existe um cartão salvo na sessão
<?php if (isset($_SESSION['cartao'])): ?>
    var cartaoSalvo = document.getElementById('cartao_salvo');
    var ultimoCartao = document.getElementById('ultimo_cartao');
    
    // Exibir os últimos 4 dígitos do cartão salvo
    ultimoCartao.textContent = "****-****-****-<?php echo substr($_SESSION['cartao']['numero'], -4); ?>";
    
    // Exibir o cartão salvo
    cartaoSalvo.style.display = 'block';
<?php endif; ?>
</script>
