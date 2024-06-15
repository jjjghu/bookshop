
$(document).ready(function () {
    $('#commentForm').on('submit', function (e) {
        e.preventDefault();

        // let params = new URLSearchParams(window.location.search);
        // var productId = params.get('product_id') // 獲取網址當中的 ?id=
        console.log(productId); // 在 product.php 當中有存過 productId 變數

        var comment = $('input[name="comment"]').val();
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
    // 存下留言
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
                        alert(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('發生錯誤，請稍後再試。');
                    console.log("Error: " + error);
                    console.log("Status: " + status);
                    console.log(xhr.responseText);
                }
            });
        }
    });
    // 取消留言
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