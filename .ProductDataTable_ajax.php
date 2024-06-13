<?php
include '.LinkSql.php';

$query = "SELECT id, product_name, price, write_date, (SELECT penName FROM author WHERE id = author_id) AS author FROM products";
$result = $link->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        "id" => $row["id"],
        "product_name" => $row["product_name"],
        "price" => $row["price"],
        "author" => $row["author"],
        "write_date" => $row["write_date"],
        "actions" => '<a href="admin.php?delete_product=' . $row['id'] . '" class="btn btn-danger btn-sm"
                onclick="return confirm(\'確定要刪除這個商品嗎?\');">刪除</a>'
    );
}

echo json_encode(array("data" => $data));