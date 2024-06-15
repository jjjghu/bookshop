<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '.LinkSql.php';
include 'function.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    if ($action === 'delete') {
        // 刪除商品的邏輯
        deleteProducts($link, $product_id);
        $_SESSION['message'] = "文章已成功刪除!";
        header("Location: userProfile.php");
        exit();
    } else {
        // 更新商品資料
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

        // 更新成功後的訊息
        $_SESSION['message'] = "文章內容更新成功!";
        header("Location: userProfile.php");
        exit();
    }
}