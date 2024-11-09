/**
 * JavaScript global
 */

// Previne o reenvio de formulários ao recarregar a página:
if (window.history.replaceState)
    window.history.replaceState(null, null, window.location.href);

const bannerImages = [
    '/src/img/home-banner1.jpg',
    '/src/img/home-banner2.jpg',
    '/src/img/home-banner3.jpg',
    '/src/img/home-banner4.jpg'
];

function changeBannerImage() {
    const banner = document.querySelector('.banner');
    if (banner) {
        const randomImage = bannerImages[Math.floor(Math.random() * bannerImages.length)];
        banner.style.backgroundImage = `url(${randomImage})`;
    }
}

window.onload = changeBannerImage;

 // Atualiza o número de itens no carrinho
 const cartCount = document.querySelector('.cart-count');
 const cartItems = "<?php echo isset($_SESSION['carrinho']) ? json_encode($_SESSION['carrinho']) : '[]; ?> "
 cartCount.textContent = cartItems.length > 0 ? cartItems.length : '0';
