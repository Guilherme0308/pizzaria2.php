<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho'])) {
    header('Location: /carrinho'); // Redireciona se o carrinho estiver vazio
    exit();
}

// Verifica se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_cliente = $_POST['nome_cliente'];
    $endereco = $_POST['endereco'];
    $cep = $_POST['cep'];
    $metodo_pagamento = $_POST['metodo_pagamento'];

    // Aqui, você pode salvar os dados em um banco de dados ou processar o pagamento
    // Exemplo simples de processamento
    $pedido_id = uniqid('pedido_');
    $data_pedido = date('Y-m-d H:i:s');

    // Salvar o pedido no banco de dados ou outro sistema
    // Aqui você pode usar uma consulta de inserção no banco para salvar os detalhes do pedido

    // Exemplo de mensagem de sucesso
    $message = 'Compra realizada com sucesso!';
    
    // Limpar o carrinho após a compra
    unset($_SESSION['carrinho']);

    // Redireciona o usuário para a página de sucesso ou confirmação
    header('Location: /confirmacao-pedido.php?pedido=' . $pedido_id);
    exit();
}
?>
