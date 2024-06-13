function bindCartButton() {
    $('.cart-link').on('click', function (e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        var productName = $(this).data('product-name');
        var productPrice = $(this).data('product-price');
        console.log(productId, productName, productPrice);
        $.ajax({
            url: 'add_to_cart.php',
            type: 'POST',
            data: {
                product_id: productId,
                product_name: productName,
                product_price: productPrice
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    if (response.is_new) {
                        // 新增商品到購物車
                        var newProductHtml = '<div class="preview-product pt-3">' +
                            '<div class="d-flex justify-content-between align-items-center mb-3">' +
                            '<div class="w-75">' +
                            '<span class="me-3 clamp-lines">' + productName +
                            ' X <span class="productQuantity" data-product-id= ' + productId +
                            '>1</span></span > ' +
                            '</div>' +
                            '<div class="me-3 w-25">$<span class="productPrice"  data-product-id=' + productId + '>' + productPrice + '</span></div>' +
                            '</div>' +
                            '</div>';
                        $('#product-list').append(newProductHtml);
                    } else {
                        // console.log($("[data-product-id='" + productId + "'] .productPrice").text());
                        $(".productQuantity[data-product-id='" + productId + "']").text(response.newQuantity);
                        $(".productPrice[data-product-id='" + productId + "']").text(response.newProductSum);
                    }
                    // 更新總價格
                    var cartCount = document.getElementById('cart-count');
                    if (cartCount.textContent == 0) {
                        cartCount.style.display = 'block';
                    }
                    ++cartCount.textContent;
                    // 更新畫面數量
                    $('#productSum').text(response.total_price);
                } else {
                    alert('請先登入');
                }
            }
        });
    });
}
// $(document).ready(function () { bindCartButton(); });