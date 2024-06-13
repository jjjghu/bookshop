<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '.LinkSql.php';

if (isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    $stmt = $link->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $link->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
}

// 關閉連接
$link->close();

header("Location: order.php");
exit();
?>