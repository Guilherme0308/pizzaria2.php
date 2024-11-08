<?php
    // importa o arquivo de conexão
    require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

    // !empty não deixa os campos serem nulos
    if(isset($_GET['submit']) && !empty($_GET['email']) && !empty($_GET['senha'])){        
        
        $email = $_GET['email'];
        $senha = $_GET['senha'];

        // coloca os campos digitados no banco de dados em sql
        $sql = "SELECT * FROM users WHERE email = '$email' and senha = '$senha' ";
        $resultado = $conn->query($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);
            
            // Verifica se a senha fornecida corresponde ao hash armazenado
            if (password_verify($senha, $usuario['senha'])) {
                header("Location: profile.html");
                exit;
            } else {
                // Senha incorreta
                echo "<span>Senha incorreta.</span>";
                header("Location: login.php");
                exit;
            }
        } else {
            // Usuário não encontrado
            echo "<span>Email não encontrado.</span>";
            header("Location: login.php");
            exit;
        }
    }
    require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
?>

<body>
    <main>
        <section class="logi">


            <div class="login-box">
                <h1>Login</h1>
                <p>Ainda não é membro? <a href="cadastro.php">Cadastre-se</a></p>

                <form action="login.php" method="GET">
                    <div class="box-item">
                        <input name="email" type="email" placeholder="E-mail" required />
                        <input name="senha" type="password" placeholder="Senha" required />
                    </div>

                    <button name="submit" type="submit" id="btn">Acessar</button>

                </form>

            </div>
        </section>
    </main>
</body>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
?>