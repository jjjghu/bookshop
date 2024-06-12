<?php
include '.LinkSql.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    echo "請先登入";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($comment_id > 0) {
        $sql = "DELETE FROM product_comment WHERE id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("i", $comment_id);

        if ($stmt->execute()) {
            $response = ['success' => true];
        } else {
            $response = ['success' => false];
        }
        $stmt->close();
    } else {
        $response = ['success' => false];
    }

    $link->close();
    echo json_encode($response);
}