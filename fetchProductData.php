<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '.LinkSql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    // 獲取商品資訊
    $sql = "SELECT 
            p.product_name, 
            p.price, 
            a.penName AS author_name, 
            a.bio AS author_bio, 
            p.write_date, 
            pc.intro AS intro, 
            pc.detail AS detail,
            GROUP_CONCAT(c.id SEPARATOR ', ') AS category_ids 
        FROM products p
        JOIN author a ON p.author_id = a.id
        JOIN product_contents pc ON p.id = pc.product_id
        JOIN product_category pcg ON p.id = pcg.product_id
        JOIN categories c ON pcg.category_id = c.id
        WHERE p.id = ?";
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => '查詢失敗']);
    }

    $images = [];
    // 查詢商品圖片
    $sql_images = "SELECT image_path FROM product_images WHERE product_id = ?";
    $stmt_images = $link->prepare($sql_images);
    $stmt_images->bind_param("i", $product_id);
    $stmt_images->execute();
    $result_images = $stmt_images->get_result();
    $images = [];
    while ($row_image = $result_images->fetch_assoc()) {
        $images[] = $row_image['image_path'];
    }

    if ($product) {
        echo json_encode(['success' => true, 'product' => $product, 'images' => $images]);
    } else {
        echo json_encode(['success' => false, 'message' => '找不到資料']);
    }
}
?>