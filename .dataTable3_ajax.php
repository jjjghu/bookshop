<?php
include '../.Bookshop/.LinkSql.php';

$query = "SELECT * FROM author";
$result = $link->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $username = ($row['is_admin'] == 1) ? "<span class='text-danger'>" . $row["username"] . "</span>" : $row["username"];
    $data[] = array(
        "id" => $row["id"],
        "username" => $username,
        "penName" => $row["penName"],
        "email" => $row["email"],
        "phone" => $row["phone"],
        "actions" => '
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#AddUserModal" data-id="' . $row['id'] . '"
                data-username="' . $row['username'] . '"
                data-penName="' . $row['penName'] . '" data-email="' . $row['email'] . '"
                data-phone="' . $row['phone'] . '"
                data-is_admin="' . $row['is_admin'] . '">編輯</button>
            <a href="admin.php?delete_user=' . $row['id'] . '" class="btn btn-danger btn-sm"
                onclick="return confirm(\'確定要刪除這個使用者嗎?\');">刪除</a>'
    );
}

echo json_encode(array("data" => $data));