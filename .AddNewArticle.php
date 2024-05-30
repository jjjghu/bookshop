<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '.LinkSql.php'; // 包含資料庫連接

// 獲取所有分類
$category_query = "SELECT * FROM categories";
$category_result = $link->query($category_query);

// 獲取所有作者
$author_query = "SELECT * FROM author";
$author_result = $link->query($author_query);

// 處理新增商品
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $author_id = $_POST['author_id'];
    $write_date = $_POST['write_date'];
    $content = $_POST['content'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    // 插入商品資料
    $stmt = $link->prepare("INSERT INTO products (product_name, price, author_id, write_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $product_name, $price, $author_id, $write_date);
    $stmt->execute();
    $product_id = $stmt->insert_id;
    $stmt->close();

    // 插入商品內容
    $stmt = $link->prepare("INSERT INTO product_contents (product_id, content, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $product_id, $content, $description);
    $stmt->execute();
    $stmt->close();

    // 插入商品分類
    $stmt = $link->prepare("INSERT INTO product_category (product_id, category_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $product_id, $category_id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['message'] = '<div class="alert alert-success" role="alert">商品新增成功</div>';
    header("Location: userProfile.php");
    exit();
}