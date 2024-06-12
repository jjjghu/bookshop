<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include '.LinkSql.php';

$products = [];
$data = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // 獲取購物車資料
    $sql = "SELECT p.id, p.product_name, p.price, c.quantity, 
                   (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) AS image 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $product_id = htmlspecialchars($row['id']);
        $product_name = htmlspecialchars($row['product_name']);
        $price = htmlspecialchars($row['price']);
        $quantity = htmlspecialchars($row['quantity']);
        $image = !empty($row['image']) ? htmlspecialchars($row['image']) : 'images/book_big.png';

        $data .= "<div class='preview-product card m-3 shopping-cart'>
                    <div class='row g-0'>
                        <div class='d-flex align-items-center m-3'>
                            <img src='$image' class='preview-image'>
                            <div class='flex-grow-1 ms-3'>
                                <div class='card-body shopping-cart w-75'>
                                    <h5 class='card-title clamp-lines'>$product_name</h5>
                                    <p class='card-text my-3'>
                                        $<span class='product-price' data-price='$price'>" . $price . "
                                    </span></p>
                                    <div class='btn-group' role='group' aria-label='Quantity'>
                                        <button type='button' class='btn btn-secondary decrement'>-</button>
                                        <input min='0' value='$quantity' type='number' data-product-id='$product_id' class='btn btn-outline-secondary quantity text-Nmain'>
                                        <button type='button' class='btn btn-secondary increment'>+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>";
    }

    $stmt->close();
}
$link->close();
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>購物車</title>
    <?php include '.Style.php'; ?>
</head>
<?php include '.Theme.php'; ?>

<body class="<?php echo htmlspecialchars($theme); ?>">
    <!-- 標題橫條 + 切換按鈕 -->
    <?php include '.Header.php'; ?>
    <!-- 主要頁面內容開始 -->
    <main class="container my-5 mt-10vh">
        <div class="row">
            <!-- 商品列表 -->
            <div class="col-md-8">
                <h2>購物車</h2>
                <?php echo $data; ?>
            </div>
            <!-- 購物車摘要 -->
            <div class="col-md-4">
                <h2>總結</h2>
                <ul class="list-group mt-3" id="summary-list">
                    <?php
                    $total = 0;
                    foreach ($products as $product):
                        $productTotal = $product['price'] * $product['quantity'];
                        $total += $productTotal;
                        ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div class="w-75">
                                <h6 class="my-0 clamp-lines"><?php echo htmlspecialchars($product['product_name']); ?></h6>
                            </div>
                            <span class="text-muted w-25">
                                $<span class="product-total"
                                    data-price="<?php echo htmlspecialchars($product['price']); ?>"><?php echo htmlspecialchars($productTotal); ?></span>
                            </span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <h5 class="w-75"><strong><span class="text-orange">總計</span></strong></h5>
                        <h5 class="w-25"><strong class="text-orange">$<span
                                    id="total-price"><?php echo htmlspecialchars($total); ?></span></strong>
                        </h5>
                    </li>
                </ul>
                <button class="btn btn-success btn-lg btn-block mt-3 w-100" id="checkout-btn">結帳</button>
            </div>
        </div>
    </main>
    <!-- 主要頁面內容結束 -->
    <?php include '.Footer.php'; ?>
    <?php include '.Script.php'; ?>
    <script src="js/.ShoppingCart.js"></script>
    <script>
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
                data: { products: products, total_price: total_price},
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

    </script>
</body>

</html>