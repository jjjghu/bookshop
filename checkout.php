<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include '.LinkSql.php';

$response = ['success' => false];

if (isset($_SESSION['user_id']) && isset($_POST['products'])) {
    $user_id = $_SESSION['user_id'];
    $products = $_POST['products'];
    $total_price = $_POST['total_price'];



    $sql = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ii", $user_id, $total_price);

    if ($stmt->execute()) {
        // 獲取剛才加入的訂單編號
        $order_id = $stmt->insert_id;
        $stmt->close();

        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $link->prepare($sql);

        foreach ($products as $product) {
            $stmt->bind_param("iiii", $order_id, $product['product_id'], $product['quantity'], $product['price']);
            $stmt->execute();
        }

        $stmt->close();

        // 刪除購物車商品
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        $response['success'] = true;
    }
}

$link->close();
echo json_encode($response);
?>