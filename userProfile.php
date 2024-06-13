<?php
if (session_status() == PHP_SESSION_NONE) {
    // 沒有登入 -> 跳轉到登入頁面
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>個人資料</title>
    <link href="bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include '.Style.php' ?>
</head>
<?php include '.Theme.php'; ?>

<body class=<?php echo $theme ?>>
    <!-- 標題橫條 + 切換按鈕 -->
    <?php include '.Header.php'; ?>
    <?php include 'userProfile_sql.php'; ?>
    <!-- 主要頁面內容開始 -->
    <main class="container mt-10vh">
        <div class="row">
            <!-- 個人資料區塊開始 -->
            <div class="col-md-4">
                <div class="profile-header">
                    <div class="profile-info d-flex flex-column align-items-center mb-5">
                        <!-- <img src="images/book.png" class="profile-image mb-2"> -->
                        <div class="d-flex">
                            <h2 class="h4">
                                <!-- 使用 session, 而不是搜尋結果 -->
                                <?php echo (isset($_SESSION['penName'])) ? $_SESSION['penName'] : $_SESSION['username']; ?>
                            </h2>
                            <button type="button" id="editProfile" class="bi bi-pencil-fill ms-1 btn-small-icon"
                                data-bs-toggle="modal" data-bs-target="#editProfileModal"></button>
                        </div>
                        <!-- 訊息, 顯示是否更新成功 -->
                        <?php if (isset($_SESSION['message'])): ?>
                            <script>
                                alert(<?php echo json_encode($_SESSION['message']); ?>);
                            </script>
                            <?php unset($_SESSION['message']); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <!-- 簡介區塊 -->
                    <textarea class="form-control" rows="10" id="bio"
                        placeholder="<?php echo ($bio == "") ? '暫無簡介' : htmlspecialchars($bio); ?>" readonly></textarea>
                </div>
                <!-- <div class="d-flex">
                    <h3>※ 動態 (施工中) ※<h3>
                </div>
                <div class="scroll-box">
                    <ul>
                        <li>剛剛發布的新的文章「漫步野花中的吹笛手」</li>
                        <li>一天前發布了新的文章「一瞬時刻」</li>
                        <li>兩天前發布了新的文章「我打江南走過」</li>
                        <li>七天前發布了新的文章「我欲乘風歸去」</li>
                    </ul>
                </div> -->
            </div>
            <div class="col-md-8">
                <h3>文章撰寫</h3>
                <div class="row">
                    <div class="col-md-3">
                        <div data-bs-toggle='modal' data-bs-target='#addArticleModal'
                            class='text-decoration-none text-primary'>
                            <div class='card d-flex align-items-center justify-content-center'>
                                <i class="bi bi-file-earmark-plus"></i>
                                <h5 id="new-article" class='card-title text-Nmain clamp-lines mb-auto'>
                                    撰寫新文章
                                </h5>
                            </div>
                        </div>
                    </div>
                    <!-- --------------------------------------------------------- -->
                    <?php
                    // 搜尋文章 
                    // 找到本作者寫的所有書籍
                    foreach ($products as $product) {
                        $product_id = htmlspecialchars($product['id']);
                        $product_image = htmlspecialchars($product['image']);
                        $product_name = htmlspecialchars($product['name']);
                        $product_price = htmlspecialchars($product['price']);
                        echo "
                        <div class='col-md-3'>
                            <!-- 跳轉文章編輯 -->
                            <div data-bs-toggle='modal' data-bs-target='#editArticleModal' class='edit text-decoration-none text-primary' data-product-id='{$product_id}'>
                                <div class='card mb-3 d-flex flex-column'>
                                    <img src='{$product_image}' class='card-img-top' alt='Product Image'>
                                    <div class='card-body d-flex flex-column'>
                                        <h5 class='card-title text-Nmain clamp-lines mb-auto'>{$product_name}</h5>
                                        <button class='btn cart' aria-label='編輯圖示'>編輯</button>
                                        <p class='card-text fw-bold text-orange mt-auto'>\${$product_price}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ";
                    }

                    ?>
                    <!-- --------------------------------------------------------- -->
                </div>
                <!-- 顯示已經擁有的商品 -->
                <?php include 'ownedProduct.php'; ?>
            </div>
            <!-- 個人資料編輯區Modal -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfileModalLabel">編輯個人資料</h5>
                        </div>
                        <div class="modal-body">
                            <form id="EditProfile" action=".EditProfile.php" method="post">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="使用者名稱" value="<?php echo htmlspecialchars($username); ?>">
                                    <p class="text-danger" id="username-err"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="penName" name="penName" placeholder="筆名"
                                        value="<?php echo htmlspecialchars($penName); ?>">
                                    <p class="text-danger" id="penName-err"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" id="newpassword" name="newpassword"
                                        placeholder="新密碼(留空表示不變)">
                                    <p class="text-danger" id="newpassword-err"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="電子信箱"
                                        value="<?php echo htmlspecialchars($email); ?>">
                                    <p class="text-danger" id="email-err"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="手機號碼"
                                        value="<?php echo htmlspecialchars($phone); ?>">
                                    <p class="text-danger" id="phone-err"></p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div id="message"></div>
                                    <div>
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal"><i
                                                class="bi bi-x-circle me-1"></i>取消</button>
                                        <button type="submit" id="EditConfirm" class="btn btn-primary"><i
                                                class="bi bi-check-circle me-1"></i>保存變更</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 個人簡介 Modal -->
            <div class="modal fade" id="editbioModal" tabindex="-1" aria-labelledby="editbioModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfileModalLabel">編輯簡介</h5>
                        </div>
                        <div class="modal-body">
                            <form id="Editbio" action=".EditBio.php" method="post">
                                <div class="mb-3">
                                    <textarea id="bioTextarea" class="form-control" name="bio"
                                        rows="15"><?php echo $bio; ?></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal"><i
                                            class="bi bi-x-circle me-1"></i>取消</button>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="bi bi-check-circle me-1"></i>保存變更</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 兩個 Modal -->
            <?php include '.AddArticleModal.php'; ?>
            <?php include '.EditArticleModal.php'; ?>
        </div>
    </main>
    <!-- 主要頁面內容結束 -->
    <?php include '.Footer.php'; ?>
    <?php include '.Script.php' ?>
    <script src="js/.UserProfile.js"></script>
</body>

</html>