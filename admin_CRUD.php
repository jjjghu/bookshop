<?php
session_start();
include '.LinkSql.php'; // 包含資料庫連接

// 檢查是否為管理員
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "權限不足!";
}

// 獲取所有使用者
$query = "SELECT * FROM author";
$result = $link->query($query);
function ExecuteSQL($link, $sql, $param, $type, $count, $errorMsg)
{
    $stmt = $link->prepare($sql);
    $stmt->bind_param($type, $param);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > $count) {
        echo "<span class='text-danger'>$errorMsg</span>";
        $stmt->close();
        exit();
    }
    $stmt->close();
}

// 處理新增和修改使用者
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = $_POST['username'];
    $penName = $_POST['penName'];
    $hashed_password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // 更新使用者資料
    if (isset($_POST['user_id']) && $_POST['user_id'] != '') {

        ExecuteSQL($link, "SELECT id FROM author WHERE username = ?", $username, "s", 1, "使用者名稱已存在");
        ExecuteSQL($link, "SELECT id FROM author WHERE email = ?", $email, "s", 1, "電子郵件已存在");
        ExecuteSQL($link, "SELECT id FROM author WHERE phone = ?", $phone, "s", 1, "手機號碼已被使用");
        ExecuteSQL($link, "SELECT id FROM author WHERE penName = ?", $penName, "s", 1, "筆名已被使用");

        // 更新使用者，不更新密碼
        $user_id = $_POST['user_id'];
        $stmt = $link->prepare("UPDATE author SET username = ?, penName = ?, email = ?, phone = ?, is_admin = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $username, $penName, $email, $phone, $is_admin, $user_id);
        if ($stmt->execute()) {
            echo "<span class='text-success'>成功更新資訊</span>";
        } else {
            echo "<span class='text-danger'>更新失敗</span>";
        }
    } else {
        // 新增使用者
        ExecuteSQL($link, "SELECT id FROM author WHERE username = ?", $username, "s", 0, "使用者名稱已存在");
        ExecuteSQL($link, "SELECT id FROM author WHERE email = ?", $email, "s", 0, "電子郵件已存在");
        ExecuteSQL($link, "SELECT id FROM author WHERE phone = ?", $phone, "s", 0, "手機號碼已被使用");
        ExecuteSQL($link, "SELECT id FROM author WHERE penName = ?", $penName, "s", 0, "筆名已被使用");

        $stmt = $link->prepare("INSERT INTO author (username, penName, password, email, phone, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $username, $penName, $hashed_password, $email, $phone, $is_admin);
        if ($stmt->execute()) {
            echo "<span class='text-success'>成功新增使用者</span>";
        } else {
            echo "<span class='text-danger'>新增失敗</span>";
        }
    }
    $stmt->close();
    exit();
}

// 處理刪除使用者
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];

    // 找到所有的商品
    $stmt = $link->prepare("SELECT id FROM products WHERE author_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($product_id);

    $product_ids = [];
    while ($stmt->fetch()) {
        $product_ids[] = $product_id;
    }
    $stmt->close();

    if (!empty($product_ids)) {

        $product_ids_placeholder = implode(',', array_fill(0, count($product_ids), '?'));
        $types = str_repeat('i', count($product_ids));

        // 刪除商品圖片
        $stmt = $link->prepare("DELETE FROM product_images WHERE product_id IN ($product_ids_placeholder)");
        $stmt->bind_param($types, ...$product_ids);
        $stmt->execute();
        $stmt->close();

        // 刪除 product content
        $stmt = $link->prepare("DELETE FROM product_contents WHERE product_id IN ($product_ids_placeholder)");
        $stmt->bind_param($types, ...$product_ids);
        $stmt->execute();
        $stmt->close();

        // 刪除商品分類
        $stmt = $link->prepare("DELETE FROM product_category WHERE product_id IN ($product_ids_placeholder)");
        $stmt->bind_param($types, ...$product_ids);
        $stmt->execute();
        $stmt->close();

        // 刪除商品
        $stmt = $link->prepare("DELETE FROM products WHERE id IN ($product_ids_placeholder)");
        $stmt->bind_param($types, ...$product_ids);
        $stmt->execute();
        $stmt->close();

        // 刪除商品的留言
        $stmt = $link->prepare("DELETE FROM product_comment WHERE product_id IN ($product_ids_placeholder)");
        $stmt->bind_param($types, ...$product_ids);
        $stmt->execute();
        $stmt->close();
    }

    // 刪除使用者留下的留言
    $stmt = $link->prepare("DELETE FROM product_comment WHERE author_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->close();

    // 刪除使用者
    $stmt = $link->prepare("DELETE FROM author WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    echo "刪除使用者成功";
    Header("Location: admin.php");
    exit();
}
