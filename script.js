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


// Atualiza o valor total com base na quantidade de produtos
function atualizarTotal() {
    const preco = parseFloat(document.getElementById('valor_produto').innerText.replace('Preço: R$ ', '').replace(',', '.'));
    const quantidade = parseInt(document.getElementById('quantidade_produto').value);
    const total = (preco * quantidade).toFixed(2).replace('.', ',');

    document.getElementById('total_produto').innerText = 'R$ ' + total;
}

// Função para remover o produto
function removerProduto() {
    document.querySelector('.produto').style.display = 'none';
    document.getElementById('total_produto').innerText = 'R$ 0,00';
}

// Função para finalizar a compra
function finalizarCompra() {
    const total = document.getElementById('total_produto').innerText;
    if (total === 'R$ 0,00') {
        alert('Seu carrinho está vazio.');
    } else {
        alert('Compra finalizada!');
        // Redirecionar para uma página de confirmação ou similar
        window.location.href = '/index.html';
    }
}