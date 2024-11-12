<?php
// Inclui o arquivo de configuração global do aplicativo:
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

// Processa o formulário se o método HTTP for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitiza e valida os dados dos campos
    $nome = filter_var(trim($_POST['nome']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefone = filter_var(trim($_POST['telefone']), FILTER_SANITIZE_STRING);
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    $cep = filter_var(trim($_POST['cep']), FILTER_SANITIZE_STRING);
    $endereco = filter_var(trim($_POST['endereco']), FILTER_SANITIZE_STRING);
    $numero = filter_var(trim($_POST['numero']), FILTER_SANITIZE_STRING);
    $complemento = filter_var(trim($_POST['complemento']), FILTER_SANITIZE_STRING);
    $cidade = filter_var(trim($_POST['cidade']), FILTER_SANITIZE_STRING);
    $estado = filter_var(trim($_POST['estado']), FILTER_SANITIZE_STRING);

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($nome) || empty($email) || empty($telefone) || empty($senha) || empty($cep) || empty($endereco) || empty($numero) || empty($cidade) || empty($estado)) {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit;
    }

    // Verifica se as senhas correspondem
    if ($senha !== $confirmarSenha) {
        echo "<script>alert('As senhas não correspondem.');</script>";
        exit;
    }

    // Verifica se o e-mail já está cadastrado
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Este e-mail já está cadastrado.');</script>";
        exit;
    }

    // Criptografa a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere os dados no banco de dados com prepared statement
    $stmt = $conn->prepare("INSERT INTO users (nome, email, telefone, cep, endereco, numero, complemento, cidade, estado, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $nome, $email, $telefone, $cep, $endereco, $numero, $complemento, $cidade, $estado, $senhaHash);

    if ($stmt->execute()) {
        header("Location: /login");
        exit;
    } else {
        echo "<span>Erro ao cadastrar usuário: " . $stmt->error . "</span>";
    }
    $stmt->close();
}

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
?>

<div class="main-cadastro">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h1>Cadastro</h1>

        <p>Já é membro? <a href="/login">Login</a></p>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="confirmarSenha">Confirmar Senha:</label>
        <input type="password" id="confirmarSenha" name="confirmarSenha" required><br><br>

        <label for="cep">CEP:</label>
        <input type="text" id="cep" name="cep" required><br><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required><br><br>

        <label for="numero">Número:</label>
        <input type="text" id="numero" name="numero" required><br><br>

        <label for="complemento">Complemento:</label>
        <input type="text" id="complemento" name="complemento"><br><br>

        <label for="cidade">Cidade:</label>
        <input type="text" id="cidade" name="cidade" required><br><br>

        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" required><br><br>

        <input type="submit" name="submit" value="ENVIAR">
    </form>
</div>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
$conn->close();
?>
