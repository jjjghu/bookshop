<?php
include '.LinkSql.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordCheck = $_POST['passwordCheck'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // 檢查是否所有欄位都有值
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $check_sql = "SELECT id FROM author WHERE username = ? OR email = ?";
    $stmt = $link->prepare($check_sql);
    $stmt->bind_param("ss", $username, $email); // 兩個問號分別取代變數
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "使用者名稱或電子郵件已存在";
    } else {
        // 插入資料
        $sql = "INSERT INTO author (username, password, email, phone) VALUES (?, ?, ?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $phone);

        if ($stmt->execute()) {
            echo "註冊成功";
        } else {
            echo "註冊失敗: " . $stmt->error;
        }
    }
    $stmt->close();
    $link->close();
}
