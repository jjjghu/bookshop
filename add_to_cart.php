<?php
// 商品數量 + 1
include_once '.LinkSql.php';
session_start();

$response = ['success' => false]; // 确保拼写正确

if (isset($_SESSION['user_id']) && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $product_price = isset($_POST['product_price']) ? floatval($_POST['product_price']) : 0.0;

    // 檢查該商品是否已存在購物車中
    $sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $is_new = true;
    $new_quantity = 1;
    if ($result->num_rows > 0) {
        // 如果存在，更新數量
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + 1;
        $update_sql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $update_stmt = $link->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_quantity, $row['id']);
        $update_stmt->execute();
        $update_stmt->close();
        $is_new = false;
    } else {
        // 如果不存在，插入新的記錄
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $insert_stmt = $link->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $user_id, $product_id);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    $stmt->close();

    // 計算總價格
    $total_price_sql = "SELECT SUM(c.quantity * p.price) as total_price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?";
    $total_price_stmt = $link->prepare($total_price_sql);
    $total_price_stmt->bind_param("i", $user_id);
    $total_price_stmt->execute();
    $total_price_result = $total_price_stmt->get_result();
    $total_price_row = $total_price_result->fetch_assoc();
    $total_price = $total_price_row['total_price'];

    $newProductSum_sql = "SELECT SUM(c.quantity * p.price) as newProductSum FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ? AND product_id = ?";
    $newProductSum_stmt = $link->prepare($newProductSum_sql);
    $newProductSum_stmt->bind_param("ii", $user_id, $product_id);
    $newProductSum_stmt->execute();
    $newProductSum_result = $newProductSum_stmt->get_result();
    $newProductSum_row = $newProductSum_result->fetch_assoc();
    $newProductSum = $newProductSum_row['newProductSum'];

    $total_price_stmt->close();

    // 返回新的商品資料和總價格

    $response = [
        'success' => true,
        'is_new' => $is_new,
        'total_price' => floor($total_price),
        'newProductSum' => floor($newProductSum),
        'newQuantity' => $new_quantity
    ];
}

$link->close();
echo json_encode($response);
?>