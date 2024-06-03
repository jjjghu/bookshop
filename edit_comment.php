<?php
include '.LinkSql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $intro = isset($_POST['content']) ? trim($_POST['content']) : '';

    if ($comment_id > 0 && !empty($intro)) {
        $sql = "UPDATE product_comment SET content = ? WHERE id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("si", $intro, $comment_id);

        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'comment' => [
                    'content' => nl2br(htmlspecialchars($intro))
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