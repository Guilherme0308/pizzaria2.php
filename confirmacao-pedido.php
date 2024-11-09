<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

$pedido_id = isset($_GET['pedido']) ? $_GET['pedido'] : null;

$page_article = '<h1>Confirmação de Pedido</h1>';
$page_article .= '<p>Seu pedido foi realizado com sucesso! ID do pedido: ' . htmlspecialchars($pedido_id) . '</p>';
$page_article .= '<p>Agradecemos por sua compra!</p>';



if (!$pedido_id) {
    header('Location: / ');
    exit();
}

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
echo "<article>{$page_article}</article>";
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
?>
