<?php
include '.LinkSql.php';
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id > 0) {
    // 查詢商品基本資訊和內容
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
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // 後兩位數都是 0 就只顯示整數
        $price = floatval($row['price']);
        $formatted_price = ($price == intval($price)) ? intval($price) : $price;

        $product_name = $row['product_name']; // 商品名稱
        $author_name = $row['author_name']; // 作者
        $author_bio = empty($row['author_bio']) ? '暫無簡介' : $row['author_bio'];
        $write_date = $row['write_date']; // 寫作時間
        $product_intro = nl2br($row['intro']); // 商品介紹 
        $product_detail = nl2br($row['detail']); // 商品資訊 (詳細資料)

        // 查詢商品分類
        $sql_categories = "SELECT c.name AS category_name 
                           FROM categories c
                           JOIN product_category pc ON c.id = pc.category_id
                           WHERE pc.product_id = ?";
        $stmt_categories = $link->prepare($sql_categories);
        $stmt_categories->bind_param("i", $product_id);
        $stmt_categories->execute();
        $result_categories = $stmt_categories->get_result();
        $categories = [];
        while ($row_category = $result_categories->fetch_assoc()) {
            $categories[] = $row_category['category_name'];
        }
        $category_names = implode(', ', $categories);

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

        // 假設沒有圖片，使用預設圖片
        if (empty($images)) {
            $images[] = 'images/book_big.png';
        }

        // 獲取留言
        $sql_comments = "SELECT id, author_name, author_id, comment_date, content FROM product_comment WHERE product_id = ?";
        $stmt_comments = $link->prepare($sql_comments);
        $stmt_comments->bind_param("i", $product_id);
        $stmt_comments->execute();
        $result_comments = $stmt_comments->get_result();
        $comments = [];
        while ($row_comment = $result_comments->fetch_assoc()) {
            $comments[] = $row_comment;
        }
        $stmt->close();
        $stmt_categories->close();
        $stmt_images->close();
        $stmt_comments->close();
    } else {
        echo $result->num_rows == 0 ? "<div class='mt-10vh'>找不到商品資料</div>" : "<div class='mt-10vh'>找到多筆商品資料, 請確認ID是否正確</div>";
        exit;
    }
} else {
    echo "<div class='mt-10vh'> 無效的商品 ID</div>";
    exit;
}

$link->close();