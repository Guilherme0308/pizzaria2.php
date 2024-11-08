<?php
    // importa o arquivo de conexão
    require($_SERVER['DOCUMENT_ROOT'] . '/_config.php');
        
    // isset() verifica se algo é diferente de null, no caso, se há uma variável tipo submit
    if(isset($_POST['submit'])){
 
        // variável para cada campo com seu name=""
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmarSenha'];
        $cep = $_POST['cep'];
        $endereco = $_POST['endereco'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];

        //confirmar senhas
        if ($senha !== $confirmarSenha) {
            echo "<span>As senhas não correspondem.</span>";
            exit;
        }

        //criptografa
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // coloca os campos digitados no banco de dados em sql
        $adicionar = mysqli_query($conn, "INSERT INTO users (nome, email, telefone, cep, endereco, numero, complemento, cidade, estado, senha) 
        VALUES ('$nome', '$email', '$telefone', '$cep', '$endereco', '$numero', '$complemento', '$cidade', '$estado', '$senhaHash')");

        if ($adicionar) {
            header("Location: login.php");
        } else {
            echo "<span>Erro ao cadastrar usuário.</span>";
        }    
    }
    require($_SERVER['DOCUMENT_ROOT'] . '/_header.php');
?>

<body>
    <main>
        <section class="cadast">
            <div class="box-cadast">

                <h1>Criar Conta</h1>
                <p>Já é membro? <a href="login.php">Login</a></p>

                <form id='form-cadastro' action="cadastro.php" method="POST">
                    <div class="box-item" id="nome">
                        <input name="nome" type="text" placeholder="Nome" required />
                    </div>

                    <div class="box-item" id="email">
                        <input name="email" type="email" placeholder="E-mail" required />
                    </div>

                    <div class="box-item" id="telefone">
                        <input name="telefone" type="number" placeholder="Telefone" required />
                    </div>

                    <div class="box-item" id="pass">
                        <input name="senha" type="password" id="senha" placeholder="Senha" required />                        
                    </div>
                    
                    <span class='span-validador'></span>

                    <div class="box-item" id="pass">
                        <input name="confirmarSenha" type="password" id="confirmarSenha" placeholder="Confirmar Senha" required />
                    </div>

                    <div class="box-item" id="endereco">
                        <input name="endereco" type="text" id="endereco" placeholder="Endereço" required />
                    </div>

                    <div class="box-group">
                        <input name="cep" type="number" id="cep" placeholder="CEP" required />
                        <input name="numero" type="number" id="numero" placeholder="Número" required />
                    </div>

                    <div class="box-item" id="complemento">
                        <input name="complemento" type="text" placeholder="Complemento" />
                    </div>

                    <div class="box-group" id="cidade">
                        <input name="cidade" type="text" placeholder="Cidade" required />
                        <input name="estado" type="text" placeholder="Estado" required />
                    </div>

                    <button name="submit" type="submit" id="btn">Enviar</button>

                </form>

            </div>
        </section>
    </main>
</body>
<script src="assets/js/cadastro.js"></script>

<?php
    require($_SERVER['DOCUMENT_ROOT'] . '/_footer.php');
?>