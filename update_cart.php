<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '.LinkSql.php';

$response = ['success' => false];

if (isset($_SESSION['user_id'], $_POST['product_id'], $_POST['quantity'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // 更改商品數量
    if ($quantity > 0) {
        $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        if ($stmt->execute()) {
            $response['success'] = true;
        }
        $stmt->close();
    } else if ($quantity == 0) { // 商品數量歸零, 刪除商品
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        if ($stmt->execute()) {
            $response['success'] = true;
        }
        $stmt->close();
    }
}

$link->close();
echo json_encode($response);
