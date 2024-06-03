<?php
include '.LinkSql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';

    if ($comment_id > 0 && !empty($content)) {
        $sql = "UPDATE product_comment SET content = ? WHERE id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("si", $content, $comment_id);

        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'comment' => [
                    'content' => nl2br(htmlspecialchars($content))
                ]
            ];
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