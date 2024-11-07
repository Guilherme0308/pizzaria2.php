<footer class="footer-wrapper">
    <div class="footer-content">
        <!-- Logo e Slogan -->
        <div class="footer-logo-container">
            <a href="/" title="Página inicial">
                <img src="<?php echo $site_logo ?>" alt="Logotipo de <?php echo $site_name ?>" class="footer-logo">
            </a>
            <h2><?php echo $site_name ?></h2>
            <p class="footer-slogan"><?php echo $site_slogan ?></p>
        </div>

        <!-- Links Rápidos -->
        <nav class="footer-nav">
            <h3>Links Rápidos</h3>
            <ul>
                <li><a href="/" title="Início"><i class="fa-solid fa-house fa-fw"></i> Início</a></li>
                <li><a href="/cardapio.php" title="Cardápio"><i class="fa-solid fa-utensils fa-fw"></i> Cardápio</a></li>
                <li><a href="/sobre.html" title="Sobre"><i class="fa-solid fa-circle-info fa-fw"></i> Sobre</a></li>
                <li><a href="/contato.html" title="Contato"><i class="fa-solid fa-comments fa-fw"></i> Contato</a></li>
            </ul>
        </nav>

        <!-- Redes Sociais -->
        <div class="footer-social">
            <h3>Conecte-se</h3>
            <a href="https://facebook.com" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://instagram.com" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://twitter.com" title="Twitter"><i class="fa-brands fa-twitter"></i></a>
        </div>
    </div>

    <!-- Direitos Autorais -->
    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> <?php echo $site_name ?>. Todos os direitos reservados.</p>
    </div>
</footer>


<?php
// Carrega JavaScript global 
?>
<script src="/script.js"></script>

<?php
// Se existe o arquivo 'script.js' na pasta da página, carrega ele:
if (file_exists('script.js')) echo '<script src="script.js"></script>';
?>

</body>
</html>