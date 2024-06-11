<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '.LinkSql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('Request received');
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    error_log('Product ID: ' . $product_id);

    $sql = "SELECT 
                p.product_name, 
                p.price, 
                a.penName AS author_name, 
                a.bio AS author_bio, 
                p.write_date, 
                pc.intro AS intro, 
                pc.detail AS detail 
            FROM products p
            JOIN author a ON p.author_id = a.id
            JOIN product_contents pc ON p.id = pc.product_id
            WHERE p.id = ?";

    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if ($product) {
            error_log('Product found');
            echo json_encode(['success' => true, 'product' => $product]);
        } else {
            error_log('Product not found');
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
    } else {
        error_log('Database query failed');
        echo json_encode(['success' => false, 'message' => 'Database query failed']);
    }
}
?>