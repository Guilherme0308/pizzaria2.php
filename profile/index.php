<?php
// Inclui o arquivo de configuração global
require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

// Processa a atualização do perfil, se o método HTTP for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $nome = trim($_POST['nome']);
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verifica se a senha foi atualizada e se corresponde
    if (!empty($nova_senha) && $nova_senha === $confirmar_senha) {
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET senha = ? WHERE email = ?");
        $stmt->bind_param("ss", $nova_senha_hash, $email);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Senha atualizada com sucesso!');</script>";
    } elseif (!empty($nova_senha)) {
        echo "<script>alert('As senhas não coincidem.');</script>";
    }

    // Atualiza o nome do usuário
    if (!empty($nome)) {
        $stmt = $conn->prepare("UPDATE users SET nome = ? WHERE email = ?");
        $stmt->bind_param("ss", $nome, $email);
        $stmt->execute();
        $_SESSION['name'] = $nome;
        $stmt->close();
        echo "<script>alert('Nome atualizado com sucesso!');</script>";
    }

    // Atualiza o avatar, se um novo arquivo for enviado
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        $avatar_ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $avatar_path = "/src/avatars/" . $_SESSION['user_id'] . '.' . $avatar_ext;

        // Verifica se o diretório existe e cria, se necessário
        $avatar_directory = $_SERVER['DOCUMENT_ROOT'] . "/src/avatars/";
        if (!file_exists($avatar_directory)) {
            mkdir($avatar_directory, 0777, true);
        }

        // Move o arquivo para o diretório de imagens
        if (move_uploaded_file($avatar_tmp, $_SERVER['DOCUMENT_ROOT'] . $avatar_path)) {
            $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE email = ?");
            $stmt->bind_param("ss", $avatar_path, $email);
            $stmt->execute();
            $_SESSION['avatar'] = $avatar_path;
            $stmt->close();
            echo "<script>alert('Avatar atualizado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao carregar a imagem.');</script>";
        }
    }
}

// Obtém os dados do usuário para exibir no perfil
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT nome, avatar FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
?>


<div class="profile">
    <div class="profile-avatar">
        <img src="<?php echo !empty($user['avatar']) ? $user['avatar'] : '/img/default-avatar.png'; ?>" alt="Avatar de <?php echo $_SESSION['name']; ?>">
    </div>
    <div class="profile-info">
        <h2>Perfil de <?php echo $_SESSION['name']; ?></h2>
        <form method="post" enctype="multipart/form-data" class="profile-details">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $user['nome']; ?>" required>

            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha">

            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha">

            <label for="avatar">Novo Avatar:</label>
            <input type="file" id="avatar" name="avatar" accept="image/*">

            <input type="submit" value="Atualizar Perfil">
        </form>
        <a href="/logout.php" class="logout-button">SAIR</a>
    </div>
</div>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
$conn->close();
?>
