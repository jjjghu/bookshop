<?php
include '.LinkSql.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordCheck = $_POST['passwordCheck'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    include '.Name_mail_check.php';
    // 插入資料
    $sql = "INSERT INTO author (username, password, email, phone) VALUES (?, ?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("ssss", $username, $hashed_password, $email, $phone);

    if ($stmt->execute()) {
        echo "註冊成功";
    } else {
        echo "註冊失敗: " . $stmt->error;
    }

    $stmt->close();
    $link->close();
}
