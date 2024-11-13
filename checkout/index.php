<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

//colocar carão no banco de dados


// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho'])) {
    header('Location: /carrinho'); // Redireciona para o carrinho se estiver vazio
    exit();
}

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
$page_article .= '<form id="form-cartao" action="/processar-compra.php" method="POST" class="checkout-form">';
$page_article .= '<label for="nome_cliente">Nome Completo:</label>';
$page_article .= '<input type="text" id="nome_cliente" name="nome_cliente" required>';

$page_article .= '<label for="endereco">Endereço de Entrega:</label>';
$page_article .= '<input type="text" id="endereco" name="endereco" required>';

$page_article .= '<label for="cep">CEP:</label>';
$page_article .= '<input type="number" id="cep" name="cep" required>';

$page_article .= '<label for="metodo_pagamento">Método de Pagamento:</label>';
$page_article .= '<select name="metodo_pagamento" id="metodo_pagamento" required>';
$page_article .= '<option value="">Selecione</option>';
$page_article .= '<option value="cartao">Cartão de Crédito</option>';
$page_article .= '</select>';

$page_article .= '<div id="dados_cartao" style="display: none;">';
$page_article .= '<h3>Informações do Cartão de Crédito</h3>';
$page_article .= '<label for="numero_cartao">Número do Cartão:</label>';
$page_article .= '<input type="number" id="numero_cartao" name="numero_cartao" maxlength="16" placeholder="XXXX-XXXX-XXXX-XXXX" required>';

$page_article .= '<label for="validade_cartao">Data de Validade (MM/AA):</label>';
$page_article .= '<input type="number" id="validade_cartao" name="validade_cartao" maxlength="5" placeholder="MM/AA" required>';

$page_article .= '<label for="cvv">Código de Segurança (CVV):</label>';
$page_article .= '<input type="number" id="cvv" name="cvv" maxlength="3" placeholder="CVV" required>';
$page_article .= '</div>';

$page_article .= '<button type="submit" id="cartaoBtn" class="btn-finalizar-compra">Finalizar Compra</button>';
$page_article .= '</form>';

$page_article .= '</div>';

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
echo "<article>{$page_article}</article>";
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
?>

<script>
// Controle de exibição do formulário de cartão
document.getElementById('metodo_pagamento').addEventListener('change', function() {
    var metodoPagamento = this.value;
    var dadosCartao = document.getElementById('dados_cartao');
    dadosCartao.style.display = metodoPagamento === 'cartao' ? 'block' : 'none';
});

// Validações e formatação
const formCard = document.getElementById('form-cartao');
const numeroCartao = document.getElementById('numero_cartao');
const cvv = document.getElementById('cvv');
const spanAviso = document.createElement('span');
spanAviso.classList.add('span-required');
spanAviso.style.display = 'none';
spanAviso.style.color = 'red';
formCard.appendChild(spanAviso);

// Limitar a entrada a números
numeroCartao.addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '');
});

cvv.addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '');
});

// RegEx para cartões suportados: Visa, Elo, Mastercard
var cartoesSuportados = {
    visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
    elo: /^(40117[89]|431274|438935|451416|457393|457631|457632|504175|627780|636297|636368|65500[01]|65165[234]|65048[5-8]|506699|5067[06]\d|50677[0-8]|509\d{3})\d{10}$/,
    mastercard: /^5[1-5][0-9]{14}$|^2(?:2(?:2[1-9]|[3-9][0-9])|[3-6][0-9][0-9]|7(?:[01][0-9]|20))[0-9]{12}$/
};

//validar número de cartão usando o algoritmo de luh
function validadorNumero() {
    var soma = 0;
    var shouldDouble = false;
    for (var i = numeroCartao.value.length - 1; i >= 0; i--) {
        var digito = parseInt(numeroCartao.value.charAt(i));
        if (shouldDouble && (digito *= 2) > 9) digito -= 9;
        soma += digito;
        shouldDouble = !shouldDouble;
    }
    return (soma % 10) == 0;
}

// Validação de CVV
function validadorCVV() {
    return /^\d{3,4}$/.test(cvv.value);
}

// Validação no envio
formCard.addEventListener('submit', function(event) {
    let isValid = true;

    if (!validadorNumero() || !Object.values(cartoesSuportados).some(regex => regex.test(numeroCartao.value))) {
        spanAviso.textContent = "Número de cartão inválido.";
        spanAviso.style.display = 'block';
        isValid = false;
    } else {
        spanAviso.style.display = 'none';
    }

    if (!validadorCVV()) {
        spanAviso.textContent = "CVV inválido.";
        spanAviso.style.display = 'block';
        isValid = false;
    }

    if (!isValid) event.preventDefault();
});
</script>