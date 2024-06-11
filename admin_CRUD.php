<?php
session_start();

// 檢查是否為管理員
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "權限不足!";
    exit();
}

include '.LinkSql.php';
include 'function.php'; // 通用函數
// 獲取所有使用者
$query = "SELECT * FROM author";
$result = $link->query($query);

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

    // 使用通用函數刪除所有相關的商品
    deleteProducts($link, $product_ids);

    // 刪除使用者留下的留言
    deleteUserComments($link, $user_id);

    // 刪除使用者
    $stmt = $link->prepare("DELETE FROM author WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    echo "刪除使用者成功";
    header("Location: admin.php");
    exit();
}
?>