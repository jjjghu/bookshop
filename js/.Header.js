document.addEventListener('DOMContentLoaded', () => {
    // 黑暗模式切換按鈕, 都在Loaded之後確認按紐存在, 再加入功
    var cartCount = document.getElementById('cart-count');
    if (cartCount) {

        if (cartCount.textContent == 0) {
            cartCount.style.display = 'none';
        }
        else cartCount.style.display = 'block';
    }
    var themeIcon = document.getElementById('themeIcon');
    if (themeIcon) {
        themeIcon.onclick = function () {
            document.body.classList.toggle('dark-theme');
            themeIcon.classList.toggle('bx-brightness');
            themeIcon.classList.toggle('bx-moon');
            // 用 js 將 cookie 存放在瀏覽器中
            if (document.body.classList.contains('dark-theme')) {
                document.cookie = "theme=dark-theme; path=/";

            } else {
                document.cookie = "theme=none; path=/";
            }
        }
    }
    // 顯示購物車頁面的按鈕
    var toggleCart = document.getElementById('toggleCart');
    if (toggleCart) {
        toggleCart.onclick = function () {
            var cartPreview = document.getElementById('cart-preview');
            // 將 cart-preview 當中的 display 設定為 flex
            if (cartPreview) {
                cartPreview.style.display = cartPreview.style.display === 'flex' ? 'none' : 'flex';
            }
        }
    }
});

