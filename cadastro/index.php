<?php

// Inclui o arquivo de configuração global do aplicativo:
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

// Processa o formulário se o método HTTP for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza os dados
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Valida os dados
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    // Verifica se o email já existe
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Este email já está cadastrado.');</script>";
        exit;
    }

    // Insere os dados no banco
    $stmt = $conn->prepare("INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        header('Location: index.php'); // Substitua 'index.php' pelo nome da sua página inicial
        
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}
require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');

// Formulário HTML
?>
<div class="main-cadastro">
    

    <h2>Cadastro</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        <input type="submit" value="Cadastrar">
        <a href="/login">logue-se</a>
    </form>
</div>
<?php
// Inclui o rodapé do template nesta página.
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
$conn->close();
?>  