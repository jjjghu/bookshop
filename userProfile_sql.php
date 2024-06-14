<?php include '.LinkSql.php';
// 找到使用者 id, 獲取資料
$check_sql = "SELECT username, bio, phone, email, penName FROM author WHERE id = ?";
$stmt = $link->prepare($check_sql);
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows == 1) {
    //獲取個人資訊
    $stmt->bind_result($username, $bio, $phone, $email, $penName);
    $stmt->fetch();
}

$sql = "SELECT id, product_name, price, write_date, (SELECT image_path FROM product_images WHERE product_id = products.id LIMIT 1) AS image FROM products WHERE author_id = ? ORDER BY write_date DESC";
$stmt = $link->prepare($sql);
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $product_name, $price, $write_date, $image_path);

$products = [];
if ($stmt->num_rows > 0) {
    while ($stmt->fetch()) {
        $price = floatval($price);
        $formatted_price = ($price == intval($price)) ? intval($price) : $price;
        $products[] = [
            "id" => $id,
            "name" => $product_name,
            "image" => $image_path ? $image_path : "images/book_big.png",
            "price" => $formatted_price
        ];
    }
}