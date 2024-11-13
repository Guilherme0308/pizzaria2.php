<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Xêro Pizzaria | A melhor Pizzaria!</title>
</head>

<body>
    <header>
        <!-- Logo e título do site -->
        <div class="logo-container">
            <a href="/" title="Página inicial">
                <img src="<?php echo $site_logo; ?>" alt="Logotipo de <?php echo $site_name; ?>" class="logo">
            </a>
            <h1><?php echo $site_slogan; ?></h1>
        </div>

        <!-- Barra de navegação -->
        <nav class="main-nav">
            <a href="/" title="Página inicial">
                <i class="fa-solid fa-house fa-fw"></i>
                <span>Início</span>
            </a>
            <a href="/cardapio" title="Cardápio">
                <i class="fa-solid fa-utensils fa-fw"></i>
                <span>Cardápio</span>
            </a>
            <a href="/about" title="Sobre">
                <i class="fa-solid fa-circle-info fa-fw"></i>
                <span>Sobre</span>
            </a>
            <div class="user-profile">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <a href="/profile" title="Ver perfil de <?php echo $_SESSION['name']; ?>" class="menu-user">
                        <!-- Verificação para imagem de avatar -->
                        <img src="<?php echo !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : '/img/default-avatar.png'; ?>" 
                             alt="Foto de perfil de <?php echo $_SESSION['name']; ?>" class="user-avatar">
                        <span>Perfil</span>
                    </a>
                <?php else : ?>
                    <a href="/login" title="Logue-se...">
                        <i class="fa-solid fa-user fa-fw"></i> Entrar
                    </a>
                <?php endif; ?>
            </div>
        </nav>

        <!-- Carrinho e campo de busca -->
        <div class="header-extras">
            <div class="cart">
                <a href="/carrinho" title="Carrinho">
                    <i class="fa fa-shopping-cart cart-icon"></i>
                    <span class="cart-count"><?php echo isset($_SESSION['carrinho'])?></span>
                </a>
            </div>
        </div>
    </header>

