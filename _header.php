<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title><?php echo $site_name; ?> .:. <?php echo $page_title; ?></title>
</head>

<body>
    <header>
        <!-- Logo e título do site -->
        <div class="logo-container">
            <a href="/" title="Página inicial">
                <img src="<?php echo $site_logo; ?>" alt="Logotipo de <?php echo $site_name; ?>" class="logo">
            </a>
            <h1><?php echo $site_name; ?><small><?php echo $site_slogan; ?></small></h1>
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


            <!-- Perfil do usuário ou link de login -->
            <?php if (isset($usuario)) : ?>
                <a href="/profile" title="Ver perfil de <?php echo $usuario['name']; ?>" class="menu-user">
                    <img src="<?php echo $usuario['avatar']; ?>" alt="Foto de perfil de <?php echo $usuario['name']; ?>" class="user-avatar">
                    <span>Perfil</span>
                </a>
            <?php else : ?>
                <a href="/login" title="Logue-se...">
                    <i class="fa-solid fa-user fa-fw"></i>
                    <span>Entrar</span>
                </a>
            <?php endif; ?>
        </nav>

        <!-- Carrinho e campo de busca -->
        <div class="header-extras">
            <div class="cart">
                <a href="carrinho" title="Carrinho">
                    <i class="fa fa-shopping-cart cart-icon"></i>
                    <span class="cart-count"></span>
                </a>
            </div>
        </div>
    </header>