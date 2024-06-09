<?php
include '.LinkSql.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if (!empty($comment) && $product_id > 0) {
        $author_name = $_SESSION['penName'];
        $author_id = $_SESSION['user_id'];
        $comment_date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO product_comment (product_id, content, author_name, author_id, comment_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("issss", $product_id, $comment, $author_name, $author_id, $comment_date);

        if ($stmt->execute()) {
            $comment_id = $stmt->insert_id;
            $response = [
                'success' => true,
                'comment' => [
                    'id' => $comment_id,
                    'author_name' => htmlspecialchars($author_name),
                    'comment_date' => htmlspecialchars($comment_date),
                    'content' => nl2br(htmlspecialchars($comment)),
                    'author_id' => htmlspecialchars($author_id)
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
