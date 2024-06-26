<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>商品頁面</title>
    <?php include '.Style.php' ?>
</head>
<?php include '.Theme.php'; ?>

<body class=<?php echo $theme ?>>
    <!-- 標題橫條 + 切換按鈕 -->
    <?php include '.Header.php'; ?>
    <?php include '.ProductDetail.php'; ?>
    <script>
        // 獲取 productId, 用在 comment_CURD 上
        var productId = <?php echo json_encode($product_id); ?>;
    </script>
    <main class="container">
        <div class="row">
            <div class="col-md-6">
                <!-- 距離標題 10vh -->
                <div class="slider-wrapper product mt-10vh">
                    <div class="slider product">
                        <?php foreach ($images as $index => $image_data): ?>
                            <img id="slider-<?php echo $index + 1; ?>" src="<?php echo $image_data; ?>" class="slider-img"
                                alt="slider <?php echo $index + 1; ?>">
                        <?php endforeach; ?>
                    </div>
                    <div class="slider-nav product">
                        <?php foreach ($images as $index => $image_data): ?>
                            <a data-index="<?php echo $index; ?>"></a>
                        <?php endforeach; ?>
                    </div>
                    <!-- 上下頁面 -->
                    <?php
                    if (count($images) > 0) {
                        echo '<div class="prev-arrow fs-2"><i class="bx bx-chevron-left"></i></div>';
                        echo '<div class="next-arrow fs-2"><i class="bx bx-chevron-right"></i></div>';
                    }
                    ?>
                </div>
            </div>
            <!-- 文字靠左, 距離頂部10vh-->
            <div class="col-md-6 mt-10vh text-start">
                <h2 class='fs-1 mt-2 clamp-lines'> <?php echo htmlspecialchars($product_name) ?></h2>
                <p class='fs-4 text-orange mt-3'><span class='fs-3'>$</span><?php echo htmlspecialchars($price) ?></p>
                <div class='mt-2' id='author'>作者: <?php echo htmlspecialchars($author_name) ?></div>
                <div class='mt-2' id='write_date'>出版日期: <?php echo htmlspecialchars($write_date) ?></div>
                <div class='mt-2' id='category'>分類: <?php echo htmlspecialchars($category_names) ?></div>
                <!-- 按鈕靠左 -->
                <div class="d-flex justify-content-start mt-3">
                    <button class="btn btn-primary me-2" id='add-to-cart'><i
                            class="bx bx-cart-add me-1"></i>加入購物車</button>
                    <button class="btn btn-success" id='buy-now'>直接購買</button>
                </div>
            </div>
        </div>
        <!-- 簡介區域, 透過按鈕導覽 -->
        <div class="container mt-5">
            <div class="row">
                <!-- 橫向12個物件 -->
                <div class="col-md-12">
                    <!-- role: 無障礙訪問 (從bootstrap 文檔上看到的, 用不用沒有太大差別) -->
                    <ul class="nav nav-tabs bold-hr" role="tablist">
                        <!-- nav-item, 導覽物件, nav-link 導覽連接, active 為預設選取的東西 -->
                        <li class="nav-item">
                            <a class="nav-link active text_effect" data-bs-toggle="tab" href="#content-intro">內容簡介</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text_effect" data-bs-toggle="tab" href="#content-details">詳細資料</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text_effect" data-bs-toggle="tab" href="#content-author">作者介紹</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text_effect" data-bs-toggle="tab" href="#content-comments">留言區</a>
                            <!-- 外部連接留言區 -->
                        </li>
                    </ul>
                    <!-- table-content -->
                    <div class="tab-content my-3">
                        <div class="tab-pane fade show active" id="content-intro">
                            <p><?php echo nl2br(htmlspecialchars($product_intro)); ?></p>
                        </div>
                        <div class="tab-pane fade" id="content-details">
                            <p><?php echo nl2br(htmlspecialchars($product_detail)); ?></p>
                        </div>
                        <div class="tab-pane fade" id="content-author">
                            <p><?php echo nl2br(htmlspecialchars($author_bio)) ?> </p>
                        </div>
                        <div class="tab-pane fade" id="content-comments">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if (isset($_SESSION['penName'])): ?>
                                    <form id="commentForm" method="post" class="comment-section">
                                        <div class="d-flex">
                                            <img src="images/book.png" class="comment-image me-2">
                                            <input type="text" name="comment" class="form-control me-1" placeholder="輸入你的留言"
                                                required>
                                            <button type="submit"
                                                class="btn btn-primary bx bx-arrow-back bx-rotate-180"></button>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <div>請先設定筆名</div>
                                <?php endif; ?>
                                <!-- 留言區塊 -->
                                <div class="comment-section" id="comments">
                                    <?php foreach ($comments as $comment): ?>
                                        <div class="comment" data-comment-id="<?php echo $comment['id']; ?>">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <img src="images/book.png" class="comment-image me-2">
                                                    <span
                                                        class="comment-username"><?php echo htmlspecialchars($comment['author_name']); ?></span>
                                                </div>
                                                <span
                                                    class="comment-time"><?php echo htmlspecialchars($comment['comment_date']); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between comment-content">
                                                <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                                                <!-- 留言的人 -->
                                                <?php if ($_SESSION['user_id'] == $comment['author_id']): ?>
                                                    <div>
                                                        <i class="bx bxs-edit edit-comment"></i>
                                                        <i class="bx bx-x delete-comment"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <!-- 不是作者, 但是是管理員 -->
                                                <?php if ($_SESSION['is_admin'] == 1 && $_SESSION['user_id'] != $comment['author_id']): ?>
                                                    <div>
                                                        <i class="bx bx-x delete-comment"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="d-flex justify-content-center">
                                        <a href="login.php" class="btn btn-primary">登入</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="bold-hr mb-3"></div> -->
        </div>
    </main>
    <!-- 一個可透過按鈕選取要查看的內容, 內容簡介, 詳細資料, 作者介紹, 留言區  -->
    <?php include '.Footer.php'; ?>
</body>
<?php include '.Script.php' ?>
<script src="js/.comment_CRUD.js"></script>
<script>
    $(document).ready(function () {
        // 獲取商品詳細信息
        var productId = <?php echo json_encode($product_id); ?>;
        var productName = <?php echo json_encode($product_name); ?>;
        var productPrice = <?php echo json_encode($price); ?>;

        // 加入購物車函數
        function addToCart() {
            $.ajax({
                url: 'add_to_cart.php',
                type: 'POST',
                data: {
                    product_id: productId,
                    product_name: productName,
                    product_price: productPrice
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        if (response.is_new) {
                            // 新增商品到購物車
                            var newProductHtml = '<div class="preview-product pt-3">' +
                                '<div class="d-flex justify-content-between align-items-center mb-3">' +
                                '<div class="w-75">' +
                                '<span class="me-3 clamp-lines">' + productName +
                                ' X <span class="productQuantity" data-product-id= ' + productId +
                                '>1</span></span > ' +
                                '</div>' +
                                '<div class="me-3 w-25">$<span class="productPrice"  data-product-id=' + productId + '>' + productPrice + '</span></div>' +
                                '</div>' +
                                '</div>';
                            $('#product-list').append(newProductHtml);
                        } else {
                            // console.log($("[data-product-id='" + productId + "'] .productPrice").text());
                            $(".productQuantity[data-product-id='" + productId + "']").text(response.newQuantity);
                            $(".productPrice[data-product-id='" + productId + "']").text(response.newProductSum);
                        }
                        // 更新總價格
                        var cartCount = document.getElementById('cart-count');
                        if (cartCount.textContent == 0) {
                            cartCount.style.display = 'block';
                        }
                        ++cartCount.textContent;
                        // 更新畫面數量
                        $('#productSum').text(response.total_price);
                    } else {
                        alert('請先登入');
                    }
                }
            });
        }

        // 綁定加入購物車按鈕事件
        $('#add-to-cart').on('click', function () {
            addToCart();
        });

        // 綁定直接購買按鈕事件
        $('#buy-now').on('click', function () {
            addToCart();
            // 跳轉到購物車頁面, 需要等待商品加入購物車
            setTimeout(function () {
                window.location.href = 'shoppingcart.php';
            }, 500);
        });
    });

</script>
</body>

</html>