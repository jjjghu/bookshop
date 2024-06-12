<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include '.LinkSql.php';

$orders = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT o.id AS order_id, o.total_price, o.order_date,
                   oi.product_id, oi.quantity, oi.price,
                   p.product_name, (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) AS image
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE o.user_id = ?
            ORDER BY o.order_date DESC";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // 圖片之後要顯示 ? 
    while ($row = $result->fetch_assoc()) {
        $orders[$row['order_id']]['order_id'] = htmlspecialchars($row['order_id']);
        $orders[$row['order_id']]['total_price'] = htmlspecialchars($row['total_price']);
        $orders[$row['order_id']]['order_date'] = htmlspecialchars($row['order_date']);
        $orders[$row['order_id']]['items'][] = [
            'product_id' => htmlspecialchars($row['product_id']),
            'quantity' => htmlspecialchars($row['quantity']),
            'price' => htmlspecialchars($row['price']),
            'product_name' => htmlspecialchars($row['product_name']),
            'image' => !empty($row['image']) ? htmlspecialchars($row['image']) : 'images/book_big.png'
        ];
    }

    $stmt->close();
}

$link->close();
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的訂單</title>
    <?php include '.Script.php'; ?>
</head>
<?php include '.Theme.php'; ?>
<?php include '.Style.php'; ?>

<body class="<?php echo htmlspecialchars($theme); ?>">
    <?php include '.Header.php'; ?>
    <main class="container my-5 mt-10vh">
        <h2 class="text-center mb-4">我的訂單</h2>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order card shadow-sm mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <!-- 在前面補0, 讓訂單是8位數 -->
                            <span><strong>訂單編號</strong><span
                                    class="ms-2">#<?php echo str_pad($order['order_id'], 8, '0', STR_PAD_LEFT); ?></span></span>
                            <span class="text-orange "><strong>總金額</strong>$<span
                                    class="ms-2"><?php echo $order['total_price']; ?></span></span>
                        </div>
                        <small>訂單時間:<?php echo $order['order_date']; ?></small>
                    </div>
                    <div class="card-body overflow-auto">
                        <ul class="list-group">
                            <?php foreach ($order['items'] as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="my-0"><?php echo $item['product_name']; ?></h6>
                                        <small>
                                            數量<span class="ms-1"><?php echo $item['quantity']; ?></span>
                                            單價<span class="ms-1">$<?php echo $item['price']; ?></span>
                                        </small>
                                    </div>
                                    <span>$<?php echo $item['quantity'] * $item['price']; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <span>
                您沒有任何訂單。
            </span>
        <?php endif; ?>
    </main>
    <?php include '.Footer.php'; ?>
</body>

</html>