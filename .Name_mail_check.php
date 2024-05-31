<?php
include '.LinkSql.php';
$check_sql = "SELECT id FROM author WHERE username = ? OR email = ?";
$stmt = $link->prepare($check_sql);
$stmt->bind_param("ss", $username, $email); // 兩個問號分別取代變數
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "使用者名稱或電子郵件已存在";
    exit();
}