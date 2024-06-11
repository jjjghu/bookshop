<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '.LinkSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $write_date = $_POST['write_date'];
    $intro = $_POST['intro'];
    $detail = $_POST['detail'];
    $category_id = $_POST['category_id'];

    // 更新商品資料
    $stmt = $link->prepare("UPDATE products SET product_name = ?, price = ?, write_date = ? WHERE id = ?");
    $stmt->bind_param("sdsi", $product_name, $price, $write_date, $product_id);
    $stmt->execute();
    $stmt->close();

    // 更新商品內容
    $stmt = $link->prepare("UPDATE product_contents SET intro = ?, detail = ? WHERE product_id = ?");
    $stmt->bind_param("ssi", $intro, $detail, $product_id);
    $stmt->execute();
    $stmt->close();

    // 更新商品分類
    $stmt = $link->prepare("UPDATE product_category SET category_id = ? WHERE product_id = ?");
    $stmt->bind_param("ii", $category_id, $product_id);
    $stmt->execute();
    $stmt->close();

    // 加入新的圖片
    if (isset($_FILES['images'])) {
        $images = $_FILES['images'];
        $image_paths = [];
        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $image_path = 'images/' . $images['name'][$key];
            move_uploaded_file($tmp_name, $image_path);
            $image_paths[] = $image_path;
        }

        $sql = "INSERT INTO product_images (product_id, image_path) VALUES (?, ?)";
        $stmt = $link->prepare($sql);
        foreach ($image_paths as $image_path) {
            $stmt->bind_param("is", $product_id, $image_path);
            $stmt->execute();
        }
        $stmt->close();
    }
    // 更新成功後的訊息
    $_SESSION['message'] = $product_id;
    header("Location: userProfile.php");
    exit();
}