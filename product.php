<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>商品頁面</title>
    <?php include '.Style.php' ?>
    <?php include '.LinkSql.php'; ?>
</head>
<?php include '.Theme.php'; ?>

<body class=<?php echo $theme ?>>
    <!-- 標題橫條 + 切換按鈕 -->
    <?php include '.Header.php'; ?>
    <?php include '.ProductDetail.php'; ?>
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
                <h2 class='fs-1 mt-2'> <?php echo $product_name ?></h2>
                <p class='fs-4 text-orange mt-3'><span class='fs-3'>$</span><?php echo $price ?></p>
                <div class='mt-2' id='author'>作者: <?php echo $author_name ?></div>
                <div class='mt-2' id='write_date'>出版日期: <?php echo $write_date ?></div>
                <div class='mt-2' id='category'>分類: <?php echo $category_names ?></div>
                <!-- 按鈕靠左 -->
                <div class="d-flex justify-content-start mt-3">
                    <button class="btn btn-primary me-2" id='add-to-cart'><i
                            class="bx bx-cart-add me-1"></i>加入購物車</button>
                    <button class="btn btn-success">直接購買</button>
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
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="content-intro">
                            <p><?php echo $product_intro ?></p>
                        </div>
                        <div class="tab-pane fade" id="content-details">
                            <p><?php echo $product_detail ?></p>
                        </div>
                        <div class="tab-pane fade" id="content-author">
                            <p><?php echo $author_bio ?> </p>
                        </div>
                        <div class="tab-pane fade" id="content-comments">
                            <!-- Comment Input Section -->
                            <form id="commentForm" method="post" class="comment-section">
                                <div class="d-flex">
                                    <img src="images/book.png" class="comment-image me-2">
                                    <input type="text" name="comment" class="form-control" placeholder="輸入你的留言"
                                        required>
                                    <button type="submit"
                                        class="btn btn-primary bx bx-arrow-back bx-rotate-180"></button>
                                </div>
                            </form>
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
                                            <p>
                                                <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
                                            </p>
                                            <div>
                                                <i class='bx bxs-edit edit-comment'></i>
                                                <i class='bx bx-x delete-comment'></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
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
<script>
    $(document).ready(function () {
        $('#commentForm').on('submit', function (e) {
            e.preventDefault();

            var comment = $('input[name="comment"]').val();
            var productId = <?php echo $product_id; ?>;
            // 新增留言
            $.ajax({
                url: 'add_comment.php',
                type: 'POST',
                data: { comment: comment, product_id: productId },
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        var newComment = '<div class="comment" data-comment-id="' + data.comment.id + '">' +
                            '<div class="d-flex justify-content-between">' +
                            '<div class="d-flex align-items-center">' +
                            '<img src="images/book.png" class="comment-image me-2">' +
                            '<span class="comment-username">' + data.comment.author_name + '</span>' +
                            '</div>' +
                            '<span class="comment-time">' + data.comment.comment_date + '</span>' +
                            '</div>' +
                            '<div class="d-flex justify-content-between comment-content">' +
                            '<p>' + data.comment.content + '</p>' +
                            '<div>' +
                            '<i class="bx bxs-edit edit-comment"></i>' +
                            '<i class="bx bx-x delete-comment"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        $('#comments').prepend(newComment);
                        $('input[name="comment"]').val('');
                    } else {
                        alert('留言失敗，請稍後再試。');
                    }
                },
                error: function () {
                    alert('發生錯誤，請稍後再試。');
                }
            });
        });
        // 編輯留言
        $(document).on('click', '.edit-comment', function () {
            var commentDiv = $(this).closest('.comment');
            var commentId = commentDiv.data('comment-id');
            var commentContent = commentDiv.find('.comment-content p').text();
            commentDiv.find('.comment-content').html(
                '<textarea class="form-control edit-textarea">' + commentContent + '</textarea>' +
                '<div class="d-flex mt-2">' +
                '<i class="mx-2 save-comment bx bx-check-circle"></i>' +
                '<i class="cancel-edit bx bx-x-circle"></i>' +
                '</div>'
            );
        });

        $(document).on('click', '.save-comment', function () {
            var commentDiv = $(this).closest('.comment');
            var commentId = commentDiv.data('comment-id');
            var newContent = commentDiv.find('.edit-textarea').val();

            if (newContent !== null) {
                $.ajax({
                    url: 'edit_comment.php',
                    type: 'POST',
                    data: { id: commentId, content: newContent },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success) {
                            commentDiv.find('.comment-content').html(
                                '<p>' + data.comment.content + '</p>' +
                                '<div>' +
                                '<i class="bx bxs-edit edit-comment"></i>' +
                                '<i class="bx bx-x delete-comment"></i>' +
                                '</div>'
                            );
                        } else {
                            alert('編輯失敗，請稍後再試。');
                        }
                    },
                    error: function () {
                        alert('發生錯誤，請稍後再試。');
                    }
                });
            }
        });

        $(document).on('click', '.cancel-edit', function () {
            var commentDiv = $(this).closest('.comment');
            var originalContent = commentDiv.find('.edit-textarea').text();
            commentDiv.find('.comment-content').html(
                '<p>' + originalContent + '</p>' +
                '<div>' +
                '<i class="bx bxs-edit edit-comment"></i>' +
                '<i class="bx bx-x delete-comment"></i>' +
                '</div>'
            );
        });
        // 刪除留言
        $(document).on('click', '.delete-comment', function () {
            var commentDiv = $(this).closest('.comment');
            var commentId = commentDiv.data('comment-id');

            if (confirm('確定要刪除這則留言嗎？')) {
                $.ajax({
                    url: 'delete_comment.php',
                    type: 'POST',
                    data: { id: commentId },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success) {
                            commentDiv.remove();
                        } else {
                            alert('刪除失敗，請稍後再試。');
                        }
                    },
                    error: function () {
                        alert('發生錯誤，請稍後再試。');
                    }
                });
            }
        });
    });
</script>

</html>

<!-- 
作者： 貓膩
出版社：人民文學出版社
出版日期：2017/04/01
語言：簡體中文
定價：234元
優惠價：87折204元
內容簡介
詳細資料
ISBN：9787020127238
規格：493頁 / 21 x 14.8 x 1.5 cm / 普通級 / 1-1
出版地：中國
本書分類：文學小說> 愛情小說> 原創古典小說
推薦商品
最近瀏覽商品
購物說明
Footer
 -->
</body>
<?php include '.Script.php' ?>

</html>