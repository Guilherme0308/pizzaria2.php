<?php
// Inclui o arquivo de configuração global do aplicativo:
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

// Processa o formulário se o método HTTP for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inicia a sessão, se ainda não tiver sido iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Sanitiza e valida os dados dos campos
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.');</script>";
        exit;
    }// Verifica se o e-mail existe no banco de dados
$stmt = $conn->prepare("SELECT id, nome, senha, avatar FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('E-mail ou senha incorretos.');</script>";
    exit;
}

// Obtém os dados do usuário
$row = $result->fetch_assoc();
$senhaHash = $row['senha'];
$avatar = $row['avatar'];

// Verifica a senha
if (password_verify($senha, $senhaHash)) {
    session_start();
    session_regenerate_id(true);

    // Armazena os dados na sessão
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $row['nome'];
    $_SESSION['avatar'] = !empty($avatar) ? $avatar : '/img/default-avatar.png'; // Avatar padrão se vazio

    header("Location: /"); // Redireciona para a página inicial
    exit;
} else {
    echo "<script>alert('E-mail ou senha incorretos.');</script>";
    exit;
}



    $stmt->close();
}

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
?>

<div class="main-login">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h1>Login</h1>

        <p>Ainda não é membro? <a href="/cadastro">Cadastre-se</a></p>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <input type="submit" name="submit" value="ACESSAR">
    </form>
</div>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
$conn->close();
?>
