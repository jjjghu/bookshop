<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include '.LinkSql.php';

$ownedProducts = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // 獲取用戶擁有的商品
    $sql = "SELECT DISTINCT p.id, p.product_name, 
                   (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) AS image 
            FROM products p 
            JOIN order_items od ON p.id = od.product_id 
            JOIN orders o ON od.order_id = o.id 
            WHERE o.user_id = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $ownedProducts[] = [
            "product_id" => $row['id'],
            "product_name" => $row['product_name'],
            "image" => !empty($row['image']) ? $row['image'] : 'images/book_big.png'
        ];
    }

    $stmt->close();
}
$link->close();
?>
<?php if (!empty($ownedProducts)): ?>
    <h2>我擁有的商品</h2>
    <div class="row">
        <?php foreach ($ownedProducts as $product): ?>
            <div class='col-md-3 product-item' title='<?php echo htmlspecialchars($product["product_name"]); ?>'>
                <a href='product.php?id=<?php echo htmlspecialchars($product["product_id"]); ?>'
                    class='card-link text-decoration-none text-primary'>
                    <div class='card mb-3 d-flex flex-column'>
                        <img src='<?php echo htmlspecialchars($product["image"]); ?>' class='card-img-top' alt='Product Image'>
                        <div class='card-body d-flex flex-column'>
                            <h5 class='card-title text-Nmain clamp-lines mb-auto'>
                                <?php echo htmlspecialchars($product["product_name"]); ?>
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>