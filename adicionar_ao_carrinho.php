<?php
session_start();

// Verifica se o ID do produto foi enviado
if (isset($_POST['produto_id'])) {
    $produto_id = $_POST['produto_id'];

    // Consulta o banco de dados para pegar os detalhes do produto
    require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');
    $sql = "SELECT nome, preco, imagem FROM produtos WHERE id = $produto_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Obter o produto do banco de dados
        $produto = $result->fetch_assoc();

        // Verifica se o produto já está no carrinho
        if (!isset($_SESSION['carrinho'][$produto_id])) {
            // Adiciona o produto ao carrinho
            $_SESSION['carrinho'][$produto_id] = [
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'imagem' => $produto['imagem'],
                'quantidade' => 1
            ];
        } else {
            // Se o produto já estiver no carrinho, aumenta a quantidade
            $_SESSION['carrinho'][$produto_id]['quantidade'] += 1;
        }
    }
}

// Redireciona de volta para a página onde os produtos estão sendo listados
header('Location: /cardapio'); // Ou a página que você desejar redirecionar
exit;
?>