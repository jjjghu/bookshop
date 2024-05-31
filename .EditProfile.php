<?php
include '.LinkSql.php';
session_start(); // 確認已啟用會話
// 修改個人資料, 簡介的部分都在這裡, 需要判斷更改的內容
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收表單內容
    $username = $_POST["username"];
    $newpassword = $_POST["newpassword"];
    $penName = $_POST["penName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // 檢查使用者名稱和電子郵件
    $check_sql = "SELECT id FROM author WHERE username = ? OR email = ?";
    $stmt = $link->prepare($check_sql);
    $stmt->bind_param("ss", $username, $email); // 兩個問號分別取代變數
    $stmt->execute();
    $stmt->store_result();
    // 判斷除了自己以外的使用者
    if ($stmt->num_rows > 1) {
        echo "<span class='text-danger'>使用者名稱或電子郵件已存在</span>";
        exit;
    }

    // 檢查筆名是否已被使用
    $check_sql = "SELECT id, penName FROM author WHERE id != ? AND penName = ?;";
    $stmt = $link->prepare($check_sql);
    $stmt->bind_param("ss", $_SESSION['user_id'], $penName); // 問號取代變數
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<span class='text-danger'>筆名已被使用!</span>";
        exit;
    }

    // 都正確則更新密碼和資料
    if (empty($newpassword)) {
        // 如果密碼為空，則不更新密碼
        $update_sql = "UPDATE author SET username = ?, penName = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $link->prepare($update_sql);
        $stmt->bind_param("sssss", $username, $penName, $email, $phone, $_SESSION['user_id']);
    } else {
        // 如果密碼不為空，則更新密碼
        $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
        $update_sql = "UPDATE author SET username = ?, password = ?, penName = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $link->prepare($update_sql);
        $stmt->bind_param("ssssss", $username, $hashed_password, $penName, $email, $phone, $_SESSION['user_id']);
    }
    $stmt->execute();
    $stmt->close();
    $_SESSION['username'] = $username; // 更新 username 值'
    $_SESSION['penName'] = $penName; // 紀錄筆名
    echo "<span class='text-success'>更新成功!</span>";
    exit;
}