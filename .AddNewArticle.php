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

    // 插入商品圖片
    // 設置圖片儲存目錄
    $imageDir = 'images/';
    if (isset($_FILES['fileUpload'])) {
        for ($i = 0; $i < count($_FILES['fileUpload']['tmp_name']); $i++) {
            if ($_FILES['fileUpload']['error'][$i] === UPLOAD_ERR_OK) {
                // 獲取圖片資訊
                $tmp_name = $_FILES['fileUpload']['tmp_name'][$i];
                $file_name = basename($_FILES['fileUpload']['name'][$i]);

                // 設定目標路徑
                $target_file = $imageDir . $file_name;

                // 將圖片移動到本機
                if (move_uploaded_file($tmp_name, $target_file)) {
                    // 將路徑存到資料庫
                    $stmt = $link->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                    $stmt->bind_param("is", $product_id, $target_file);
                    $stmt->execute();
                } else {
                    echo "上傳失敗";
                }
            } else {
                echo "上傳時發生錯誤" . $_FILES['fileUpload']['error'][$i];
            }
        }
    }
    // else 沒有上傳檔案
    $_SESSION['message'] = '商品新增成功';
    header("Location: userProfile.php");
    exit();
}