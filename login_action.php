<?php
include '.LinkSql.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    $sql = "SELECT id, username, password, is_admin, penName FROM author WHERE username = ?";
    $stmt = $link->prepare($sql);
    if ($stmt === false) {
        die("失敗: " . $link->error);
    }
    // 將 ? 使用 input_username 取代
    $stmt->bind_param("s", $input_username);
    // 執行搜尋
    $stmt->execute();
    // 獲取結果
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];
        // 密碼有正確加密過
        if (password_verify($input_password, $stored_password)) {
            // 登入成功跳轉到index
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_admin'] = $row['is_admin'];
            $_SESSION['penName'] = $row['penName'];
            echo "登入成功";
        } else {
            echo "密碼不正確";
        }
    } else {
        echo "使用者名稱不存在";
    }
    $stmt->close();
}
$link->close();