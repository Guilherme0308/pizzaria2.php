<?php

// Inclui o arquivo de configuração global do aplicativo:
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

// Processar o formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Preparar a consulta SQL com prepared statements para evitar SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar a senha usando password_verify
        if (password_verify($senha, $row['password'])) {
            // Iniciar a sessão
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];

            // Redirecionar para a página de perfil
            header("Location: /profile");
            exit();
        } else {
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
}

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
// Formulário de login
?>
<div class="main-login">
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <a href="/cadastro">cadastre-se</a>
        <button type="submit">Entrar</button>

    </form>
</div>
<?php
// Inclui o rodapé do template nesta página.
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');

$conn->close();
?>