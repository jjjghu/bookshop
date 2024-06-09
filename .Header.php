<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '.LinkSql.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // 獲取購物車資料
    $sql = "SELECT p.id, p.product_name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
    $link->close();
}

?>
<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <title>Header</title>
</head>

<body>
    <header>
        <!-- 固定位置的物件放在最上面 -->
        <!-- 暗黑模式切換按鈕 -->
        <!-- 顯示當前登入的人, 連結到 userProfile -->
        <a class='userProfile' id="userProfile" href="userProfile.php"><?php if (isset($_SESSION['username']))
            echo $_SESSION['username'] ?></a>
            <i class='bx bx-moon bx-rotate-270 themeIcon' id="themeIcon"></i>
            <!-- 標題橫條開始 -->
            <nav id="title-navbar" class="navbar navbar-expand-lg justify-content-between align-items-center fixed-top">
                <div class="container-fluid d-flex justify-content-between">
                    <!--標題圖片文字開始 -->
                    <a class="text-decoration-none fs-2 text-Nmain col-md-4 d-flex align-items-center" href="index.php">
                        <img src="images/book.png" alt="" class="d-inline-block  align-text-top">
                        閱緣書坊
                    </a>
                    <!--標題圖片文字結束 -->
                    <!-- 小視窗切換按鈕開始 -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- 小視窗切換按鈕結束 -->
                    <!-- 導覽連結開始 -->
                    <div class="navbar-collapse justify-content-end collapse show" id="navbarNavDropdown">
                        <ul class="navbar-nav fs-5 text-Nmain">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item title-nav me-3 ">
                                <a class="nav-link text-Nmain" href=".Logout.php"><i class='bx bx-log-out'></i>登出</a>
                            </li>
                            <li class="nav-item title-nav me-3">
                                <a class="nav-link text-Nmain" href="userProfile.php"><i
                                        class="bx bx-home me-1"></i>會員中心</a>
                            </li>
                            <li class="nav-item title-nav me-3">
                                <div class="nav-link text-Nmain" id='toggleCart'>
                                    <span class='red-dot' id='cart-count'>0</span>
                                    <i class="bx bx-cart me-1"></i>購物車
                                </div>
                                <!-- 購物車預覽頁面開始 -->
                                <div id='cart-preview'>
                                    <!-- 商品列表開始 -->
                                    <div id='product-list'>
                                        <!-- 商品資訊開始 -->
                                        <?php foreach ($products as $product): ?>
                                            <div class="preview-product pt-3 ">
                                                <!-- 數量和價格 -->
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="w-75">
                                                        <span
                                                            class=".clamp-lines me-3 clamp-lines"><?php echo htmlspecialchars($product['product_name']); ?></span>
                                                    </div>
                                                    <div class='me-3 w-25'>
                                                        $<span class="productPrice"
                                                            data-product-id='<?php echo $product['id']; ?>'><?php echo htmlspecialchars($product['price'] * $product['quantity']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <!-- 商品資訊結束 -->
                                    </div>
                                    <!-- 商品列表結束 -->
                                    <div class='mt-3'>總價格:
                                        $<span id='productSum'><?php
                                        $total_price = array_reduce($products, function ($sum, $product) {
                                            return $sum + $product['price'] * $product['quantity'];
                                        }, 0);
                                        echo $total_price;
                                        ?></span>
                                    </div>
                                    <a href=" shoppingcart.php" class='btn btn-success mt-3'>結帳</a>
                                </div>
                                <!-- 購物車預覽頁面結束 -->
                            </li>
                            <li class="nav-item title-nav me-3">
                                <a class="nav-link text-Nmain" href="#"><i class="bx bx-book-open me-1"></i>電子書櫃</a>
                            </li>
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                <li class="nav-item title-nav me-3">
                                    <a class="nav-link text-danger" href="admin.php"><i class="bx bx-user me-1"></i>管理員</a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- me-3 = margin-right... why?-->
                            <li class="nav-item title-nav me-3 ">
                                <div class="d-flex align-items-center text-Nmain">
                                    <a class="nav-link text-Nmain" href="login.php"><i class='bx bx-log-in'></i>登入</a>
                                    <span>|</span>
                                    <a class="nav-link text-Nmain" href="register.php">註冊</a>
                                </div>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
            <!-- 導覽連結結束 -->
        </nav>
        <!-- 標題橫條結束 -->
    </header>