// 增加購物車數量
function PlusCartCount() {
    var cartCount = document.getElementById('cart-count');
    if (cartCount.textContent == 0) {
        cartCount.style.display = 'block';
    }
    ++cartCount.textContent;
}
// 減少購物車數量
function MinusCartCount() {
    var cartCount = document.getElementById('cart-count');
    if (cartCount.textContent > 0) {
        --cartCount.textContent;
    }
    if (cartCount.textContent <= 1) {
        cartCount.style.display = 'none';
    }
}
function updatePrice(input) {
    // 卡片顯示價格更新
    const productCard = input.closest('.preview-product');
    const priceElement = productCard.querySelector('.product-price');
    const pricePerUnit = priceElement.dataset.price;
    const quantity = input.value;
    const newPrice = pricePerUnit * quantity;
    const productId = input.dataset.productId;


    // 更新資料庫
    $.ajax({
        url: 'update_cart.php',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: quantity
        },
        dataType: 'json',
        success: function (response) {
            if (!response.success) {
                alert('更新購物車失敗');
            }
        },
        error: function () {
            alert('發生錯誤');
        }
    });

    // 更新前端顯示
    const productTitle = productCard.querySelector('.card-title').textContent.trim();
    document.querySelectorAll('#summary-list li').forEach(function (item) {
        const itemName = item.querySelector('h6');
        if (itemName && itemName.textContent.trim() === productTitle) {
            if (quantity == 0) {
                item.remove();
                input.closest('.preview-product').remove();
            }
            else {
                const productTotalElement = item.querySelector('.product-total');
                productTotalElement.textContent = `${newPrice} `;
            }
        }
    });
    updateTotalPrice();
}
function updateTotalPrice() {
    let totalPrice = 0;
    document.querySelectorAll('.product-total').forEach(function (priceElement) {
        const price = parseFloat(priceElement.textContent);
        totalPrice += price;
    });
    document.getElementById('total-price').textContent = `${totalPrice} `;
}
// 商品數量歸零刪除，數量減少
document.querySelectorAll('.decrement').forEach(function (button) {
    button.addEventListener('click', function () {
        var input = this.parentNode.querySelector('input[type=number]');
        input.stepDown();
        if (input.value == 0) {
            this.closest('.preview-product').remove();
        }
        // MinusCartCount();
        updatePrice(input);
    });
});
// 商品數量增加
document.querySelectorAll('.increment').forEach(function (button) {
    button.addEventListener('click', function () {
        var input = this.parentNode.querySelector('input[type=number]');
        input.stepUp();
        // PlusCartCount();, ShoppingCart 頁面當中 Header 沒有可以更新的數據
        updatePrice(input);
    });
});
// 直接修改數量輸入框
document.querySelectorAll('.quantity').forEach(function (input) {
    input.addEventListener('change', function () {
        updatePrice(input);
    });
});
// 建立訂單按鈕
document.getElementById('checkout-btn').addEventListener('click', function () {
    var products = [];
    var total_price = document.getElementById('total-price').textContent;
    // console.log(total_price); span 必須要使用 textContent
    // 獲取總價格

    document.querySelectorAll('.preview-product').forEach(function (productCard) {
        // 獲取當前購物車內的商品
        var productId = productCard.querySelector('input[type=number]').dataset.productId;
        var quantity = productCard.querySelector('input[type=number]').value;
        var price = productCard.querySelector('.product-price').dataset.price;
        products.push({
            product_id: productId,
            quantity: quantity,
            price: price
        });
    });
    console.log(products);

    $.ajax({
        // 發送請求建立訂單
        url: 'checkout.php',
        type: 'POST',
        data: { products: products, total_price: total_price },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                alert('訂單建立成功!');
                window.location.reload();
            } else {
                alert('生成訂單失敗');
            }
        },
        error: function () {
            alert('發生錯誤');
        }
    });
});

