<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
include '.LinkSql.php';

$products = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // 獲取購物車資料
    $sql = "SELECT p.product_name, p.price, c.quantity, (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) AS image 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();
}
$link->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>購物車</title>
    <link href="bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include '.Style.php' ?>
</head>
<?php include '.Theme.php'; ?>

<body class=<?php echo $theme ?>>
    <!-- 標題橫條 + 切換按鈕 -->
    <?php include '.Header.php'; ?>
    <!-- 主要頁面內容開始 -->
    <main class="container my-5 mt-10vh">
        <div class="row">
            <!-- 商品列表 -->
            <div class="col-md-8">
                <h2>購物車</h2>
                <?php foreach ($products as $product): ?>
                    <div class="preview-product card m-3 shopping-cart">
                        <div class="row g-0">
                            <div class="d-flex align-items-center m-3">
                                <img src="<?php echo $product['image'];  ?>" class="preview-image">
                                <div class="flex-grow-1 ms-3">
                                    <div class="card-body shopping-cart w-75">
                                        <h5 class="card-title clamp-lines">
                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                        </h5>
                                        <p class="card-text product-price" data-price="<?php echo $product['price']; ?>">
                                            $<?php echo htmlspecialchars(number_format($product['price'] * $product['quantity'], 2)); ?>
                                        </p>
                                        <div class="btn-group" role="group" aria-label="Quantity">
                                            <button type="button" class="btn btn-secondary decrement">-</button>
                                            <input min="0" value='<?php echo $product['quantity']; ?>' type='number'
                                                class="btn btn-outline-secondary quantity text-Nmain">
                                            <button type="button" class="btn btn-secondary increment">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
                        <li class="list-group-item d-flex justify-content-between lh-sm ">
                            <div class="w-75">
                                <h6 class="my-0 clamp-lines"><?php echo htmlspecialchars($product['product_name']); ?></h6>
                            </div>

                            <span class="text-muted product-total w-25" data-price="<?php echo $product['price']; ?>">$
                                <?php echo htmlspecialchars(number_format($productTotal, 2)); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <h5><strong><span class="text-orange">總計</span></strong></h5>
                        <h5><strong class="text-orange w-25">$<span
                                    id="total-price"><?php echo number_format($total, 2); ?></span></strong>
                        </h5>
                    </li>
                </ul>
                <button class="btn btn-success btn-lg btn-block mt-3 w-100">結帳</button>
            </div>
        </div>
    </main>
    <!-- 主要頁面內容結束 -->
    <?php include '.Footer.php'; ?>
    <?php include '.Script.php' ?>
</body>

</html>